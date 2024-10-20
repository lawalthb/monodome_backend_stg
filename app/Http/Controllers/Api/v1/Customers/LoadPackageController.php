<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Models\LoadType;
use App\Models\LoadPackage;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadPackageRequest;
use App\Http\Resources\LoadBoardResource;
use App\Http\Resources\LoadPackageResource;
use App\Http\Resources\OrderResource;
use App\Models\LoadBoard;

class LoadPackageController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;
    public function index()
    {

        $key = request()->input('search');

        $loadPackages = LoadPackage::with('loadBoard')->where('user_id', auth()->id())->where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
                ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate();


        return LoadPackageResource::collection($loadPackages);
        // return response()->json($loadPackages);
    }

    public function show($id)
    {
        $loadPackage = LoadPackage::with('order')->find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found", 404);
        }

        $fields = [
            'email' => $loadPackage->user->email,
            'amount' => str_pad($loadPackage->total_amount, 2, '0', STR_PAD_RIGHT),
        ];
        $result = payStack_checkout($fields);

        if ($result->status == true) {
            return $this->success([
                "paystack" => $result->data,
                "loadPackage" => new LoadPackageResource($loadPackage),
            ], "Successfully");
        } else {
            return $this->error(null, "Paystack key not found", 404);
        }
    }


    public function delivery_fee(Request $request, Order $order)
    {

        $order->fee += $request->increase_amount;
        $order->amount += $request->increase_amount;

        if ($order->save()) {

            $order->loadable->delivery_fee = $order->fee;
            $order->loadable->total_amount = $order->amount;
            $order->loadable->save();

            $customFields = [
                [
                    "order_no" => $order->id,
                    "from" => "order"
                ],
            ];

            $fields = [
                'email' => $order->user->email,
                'amount' => $order->amount * 100,
                "metadata"  => json_encode(['id' => $order->id, 'custom_fields' => $customFields]),
                'callback_url' => env('FE_APP_URL').'/customer'
            ];

            // call the paystack api
            $result = payStack_checkout($fields);

            return $this->success([
                "paystack" => $result->data,
                "loadPackage" => new OrderResource($order),
            ], "Successfully");
        } else {

            return $this->error(null, "unable to update delivery fee", 404);
        }
    }

    public function store(LoadPackageRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $loadType = LoadType::find($request->load_type_id);
            $validatedData = $request->validated();

            // Create a new LoadPackage instance
            // $loadPackage = $loadType->loadPackages()->create($request->validated());

            $totalAmount = $validatedData['delivery_fee'] + $validatedData['insure_amount'];


            $loadPackage = LoadPackage::firstOrCreate(
                [
                    'load_type_id' => $request->load_type_id,
                    'user_id' => $request->user()->id,
                    'delivery_fee' => $request->delivery_fee,
                    'weight' => $request->weight,
                ],
                array_merge($validatedData, ['total_amount' => $totalAmount])
            );

            if (!$loadPackage->order) {
                $order = $loadPackage->order()->create([
                    'order_no' => getNumber(),
                    //  'driver_id' => 1, // Change this to the actual driver ID
                    'amount' =>  $totalAmount,
                    'fee' =>  $validatedData['delivery_fee'],
                    'user_id' => $loadPackage->user_id,
                    'payment_status' => "Pending",
                ]);
            } else {
                $order = $loadPackage->order;
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

    public function update(LoadPackageRequest $request, $id)
    {
        $loadType = LoadType::where('user_id', auth()->id())->find($request->load_type_id);

        $loadPackage = $loadType->loadPackages()->create($request->validated());
        return $this->success(
            [
                "loadPackage" => new LoadPackageResource($loadPackage),
            ],
            "update Successfully"
        );
    }

    public function destroy($id)
    {
        $loadPackage = LoadPackage::where('user_id', auth()->id())->find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found'", 404);
        }
        $loadPackage->delete();
        return $this->success(["loadType" => new LoadPackageResource($loadPackage),], "Package Type deleted");
    }
}
