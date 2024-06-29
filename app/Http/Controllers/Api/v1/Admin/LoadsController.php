<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Truck;
use App\Models\LoadBulk;
use App\Models\LoadType;
use App\Models\LoadBoard;
use App\Models\LoadPackage;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Requests\LoadBulkRequest;
use App\Notifications\SendNotification;
use App\Http\Resources\LoadBulkResource;
use App\Http\Requests\LoadPackageRequest;
use App\Http\Resources\LoadBoardResource;
use App\Http\Resources\LoadPackageResource;


class LoadsController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;


    public function privateLoadPackageStore(LoadPackageRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $loadType = LoadType::find($request->load_type_id);
            $validatedData = $request->validated();

            // Create a new LoadPackage instance
            // $loadPackage = $loadType->loadPackages()->create($request->validated());

            // $totalAmount = $validatedData['delivery_fee'] + $validatedData['insure_amount'];
            $totalAmount = $validatedData['insure_amount'];

            $role = Role::where('name', 'Company Transport')->first();

            $loadPackage = LoadPackage::firstOrCreate(
                [
                    'load_type_id' => $request->load_type_id,
                    'user_id' => $request->user()->id ,
                    // 'delivery_fee' => $request->delivery_fee,
                    'weight' => $request->weight,
                    'is_private' =>"Yes",
                ],
                array_merge($validatedData, ['total_amount' => $totalAmount])
            );

            if (!$loadPackage->order) {
                $order = $loadPackage->order()->create([
                    'order_no' => getNumber(),
                  //  'driver_id' => 1, // Change this to the actual driver ID
                    'amount' =>  $totalAmount,
                    // 'fee' =>  $validatedData['delivery_fee'],
                    'user_id' => $loadPackage->user_id,
                    'payment_status' => "Pending",
                ]);
            } else {
                $order = $loadPackage->order; // If an order already exists, use the existing one
            }

        // Handle document uploads (if any)
        if ($request->hasFile('documents')) {
            $documents = [];

            foreach ($request->file('documents') as $file) {

                $file = $this->uploadFileWithDetails('load_documents', $file);
                $path = $file['path'];
                $name = $file['file_name'];

                // Create a record in the load_documents table
                $document = new LoadDocument([
                    'name' => $name,
                    'path' => $path,
                ]);

                // Associate the document with the LoadBulk
                $loadPackage->loadDocuments()->save($document);
            }
        }

            return $this->success([
                "loadPackage" => new LoadPackageResource($loadPackage),
                // "order" => $order, // Include the order in the response
            ], "Created Successfully");
        });
    }

    public function privateLoadBulkStore(LoadBulkRequest $request)
    {

    $loadType = LoadType::find($request->load_type_id);

    if (!$loadType) {
        return response()->json(['message' => 'LoadType not found'], 404);
    }
    $validatedData = $request->validated();

    $totalAmount =  $validatedData['insure_amount'];
    // $totalAmount = $validatedData['delivery_fee'] + $validatedData['insure_amount'];



   // $loadBulk = LoadBulk::updateOrCreate($request->validated());

    $loadBulk = LoadBulk::firstOrCreate(
        [
            'load_type_id' => $request->load_type_id,
            'user_id' => $request->user()->id ,
           // 'delivery_fee' => $request->delivery_fee,
            'weight' => $request->weight,
            'is_private' =>"Yes",
        ],
        array_merge($validatedData, ['total_amount' => $totalAmount])
    );

    $loadBulk->loadType()->associate($loadType);

    try {
        $loadBulk->save();


        if (!$loadBulk->order) {

            $order = $loadBulk->order()->create([
                'order_no' => getNumber(),
                //'driver_id' => 1,
                'amount' =>  $totalAmount,
              //  'fee' =>  $validatedData['delivery_fee'],
                'user_id' => $loadBulk->user_id,
               // 'status' => "Pending",
            ]);

        } else {
            $order = $loadBulk->order;
        }


    } catch (\Exception $e) {
        // Handle the error here
        return response()->json(['message' => 'Error creating LoadBulk', 'error' => $e->getMessage()], 500);
    }

        // Handle document uploads (if any)
        if ($request->hasFile('documents')) {
            $documents = [];

            foreach ($request->file('documents') as $file) {

                $file = $this->uploadFileWithDetails('load_documents', $file);
                $path = $file['path'];
                $name = $file['file_name'];

                // Create a record in the load_documents table
                $document = new LoadDocument([
                    'name' => $name,
                    'path' => $path,
                ]);

                // Associate the document with the LoadBulk
                $loadBulk->loadDocuments()->save($document);
            }
        }
        //event(new LoadTypeCreated($loadBulk));

        return $this->success(
            [
                "loadBulk" => new LoadBulkResource($loadBulk),
            ],
            "Created Successfully"
        );
    }


    public function assignOrderToDriver(Request $request)
    {

        $request->validate([
            'driver_id' => 'required|exists:users,id',
            'order_no' => 'required',
        ]);

        $perPage = $request->input('per_page', 10);
        $order = Order::where("order_no",$request->order_no)->where("payment_status","Pending")->first();

        if (!$order) {
            return $this->error([], "Order not found");
        }

        $user = Auth::user();
         if ($user->hasRole(['admin', 'Super Admin'])) {
        $driver = User::find($request->driver_id);
            $driver = User::find($request->driver_id);
        } else {
            $driver = User::where('id', $request->driver_id)
                          ->where('user_created_by', Auth::user()->id)
                          ->first();
        }
        if (!$driver) {
            return $this->error([], "This driver is not under you");
        }
        $truck = Truck::where("driver_user_id",$driver->id)->first();

        if (!$truck) {
            return $this->error([], "driver to truck not found!");
        }

        $order->truck_by_id = $request->truck_id;
        $order->driver_id = $request->driver_id;

        $order->save();

      //  $order =  Order::where('driver_id', auth()->id())->paginate($perPage);

        // return  new LoadBoardResource($loadBoard);

        return $this->success([
            new OrderResource($order),
        ]);

    }



    public function orderReAssign(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_no' => 'required|exists:load_boards,order_no',
                'driver_id' => 'required|exists:users,id',
            ]);
            $driver = User::findOrFail($request->driver_id);
            $loadBoard = LoadBoard::where("order_no", $request->order_no)
                //->where("acceptable_id", auth()->user()->id)
                // ->where("status", 'pending')
                ->first();

            if (!$loadBoard) {
                return $this->error([], "Order not found or has already been taken!");
            }
            // Check if driver is already assigned to an order
            if ($loadBoard->acceptable_id == $driver->id) {
                return $this->error([], "Order has already been assigned to a driver!");
            }
            $order = Order::where("order_no", $request->order_no)->first();

            $loadBoard->acceptable_id = $driver->id;
            $loadBoard->acceptable_type = get_class($driver);
            $order->placed_by_id = auth()->user()->id;

            $loadBoard->save();
            $order->save();

            $message = "You have been Re assigned an order with number " . $loadBoard->order_no . " for delivery from: " . $loadBoard->order->loadable->sender_location . " to: " . $loadBoard->order->loadable->receiver_location;
            $driver->notify(new SendNotification($driver, $message));

            return $this->success([
                new OrderResource($order),
            ]);

        });
    }

    public function removeOrder(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_no' => 'required|exists:load_boards,order_no',
                'driver_id' => 'required|exists:users,id',
            ]);
            $driver = User::findOrFail($request->driver_id);
            $loadBoard = LoadBoard::where("order_no", $request->order_no)
                ->where("acceptable_id", $driver->id)
                // ->where("status", 'pending')
                ->first();

            if (!$loadBoard) {
                return $this->error([], "Order not found or this order doesn't belong to this driver");
            }

            $order = Order::where("order_no", $request->order_no)->first();

            $loadBoard->acceptable_id = auth()->user()->id;
            $loadBoard->acceptable_type = get_class($driver);
            $loadBoard->status = "processing";
           $order->placed_by_id = null;

            $loadBoard->save();
            $order->save();

            $message = "order with number " . $loadBoard->order_no . " for delivery from: " . $loadBoard->order->loadable->sender_location . " to: " . $loadBoard->order->loadable->receiver_location." has been removed";
            $driver->notify(new SendNotification($driver, $message));

            return $this->success([
                new OrderResource($order),
            ]);

        });
    }

}

