<?php

namespace App\Http\Controllers\Api\v1\Driver;

use App\Models\User;
use App\Models\Agent;
use App\Models\Order;
use App\Models\Driver;
use App\Models\Guarantor;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Models\OrderRoutePlan;
use App\Traits\ApiStatusTrait;
use App\Services\WalletService;
use App\Traits\FileUploadTrait;
use Illuminate\Validation\Rule;
use App\Models\OrderPriceSetting;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AgentResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\DriverResource;
use App\Http\Requests\AgentFormRequest;
use App\Notifications\SendNotification;
use App\Http\Resources\LoadBoardResource;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    public function index(Request $request)
    {

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $driver = Driver::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
                $userQuery->where('address', 'like', "%{$key}%");
            })->orWhere('license_number', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($driver);
    }


    public function broadcast(Request $request)
    {
        $query = LoadBoard::whereIn('load_type_id', [1, 2])
            ->where("acceptable_id", null)
            ->where("acceptable_id", null)
            ->orderBy('created_at', 'desc');
        // Check if admin_approve in related order is 'Yes'
        $query->whereHas('order', function ($q) {
            $q->where('admin_approve', 'Yes');
        });
        // Filter by Order Number
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        // Add more filters as needed

        $perPage = $request->input('per_page', 10); // Number of items per page, defaulting to 10.

        // Use the paginate method to paginate the results
        $loadBoards = $query->paginate($perPage);

        return LoadBoardResource::collection($loadBoards);
    }


    public function singleBroadcast(Request $request, $id)
    {

        $query = LoadBoard::where("id", $id)->whereIn('load_type_id', [1, 2])->orWhere("acceptable_id", auth()->id())->orWhere("acceptable_id", null)->orderBy('created_at', 'desc');

        // Filter by Order Number
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        // Add more filters as needed

        $perPage = $request->input('per_page', 10); // Number of items per page, defaulting to 10.

        // Use the paginate method to paginate the results
        $loadBoards = $query->paginate($perPage);

        return LoadBoardResource::collection($loadBoards);
    }

    public function store(DriverRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::firstOrNew(['email' => $request->input('email')]);

            $ref_by = null;

            if ($request->has('ref_by')) {
                $ref_by = User::where("referral_code", $request->ref_by)->first();
            }

            if (!$user->exists) {
                // User doesn't exist, so create a new user
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->date_of_birth = $request->input('date_of_birth');
                $user->gender = $request->input('gender');
                $user->address = $request->input('address');
                $user->ref_by = $ref_by ? $ref_by->id : null;
                $user->referral_code = $request->referral_code ?? generateReferralCode();
                $password  = Str::random(16);
                $user->phone_number = $request->input('phone_number');
                $user->password = Hash::make($password);
                $user->user_type = 'driver';
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];

                //only send password to drivers that doesnt have motor
                //    if($request->input('have_motor') =="Yes"){
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );

                // }

                $role = Role::where('name', 'Driver')->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }


            // $data = $request->validated();
            //   $driver = Driver::create($data);


            $driver = new Driver([
                'user_id' => $user->id,
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'status' => 'Pending',
                'lga' => $request->input('lga'),
                'nin_number' => $request->input('nin_number'),
                'license_number' => $request->input('license_number'),
                'have_motor' => $request->input('have_motor'),
                'vehicle_type_id' => $request->input('vehicle_type_id'),
                // Add other agent fields here
            ]);


            $driver->proof_of_license = $this->uploadFile('driver/driver_images', $request->file('proof_of_license'));
            $driver->profile_picture = $this->uploadFile('driver/driver_images', $request->file('profile_picture'));
            // $driver->registration_documents = $this->uploadFile('agent/agent_documents', $request->file('registration_documents'));

            $driver->save();

            if ($request->hasFile('vehicle_image')) {
                $documents = [];

                foreach ($request->file('vehicle_image') as $file) {

                    $file = $this->uploadFileWithDetails('vehicle_image', $file);
                    $path = $file['path'];
                    $name = $file['file_name'];

                    // Create a record in the load_documents table
                    $document = new LoadDocument([
                        'name' => $name,
                        'path' => $path,
                        // 'loadable_id' => $driver->id, // Set the loadable_id to the driver's ID
                        //'loadable_type' => Driver::class, //
                    ]);

                    // Associate the document with the LoadBulk
                    $driver->loadDocuments()->save($document);
                }
            }


            if ($request->hasFile('guarantorProfilePictures')) {
                $guarantorProfilePictures = [];

                foreach ($request->input('guarantors') as $key => $guarantorData) {
                    $guarantor = new Guarantor([
                        'full_name' => $guarantorData['full_name'],
                        'phone_number' => $guarantorData['phone_number'],
                        'email' => $guarantorData['email'],
                        'street' => $guarantorData['street'],
                        'state' => $guarantorData['state'],
                        'lga' => $guarantorData['lga'],
                    ]);

                    $guarantor->loadable()->associate($driver);

                    $guarantorProfilePictures[] = $this->uploadFile('driver/guarantor_images', $request->file("guarantors.$key.profile_picture"));

                    $driver->guarantors()->save($guarantor);
                }

                foreach ($driver->guarantors as $key => $guarantor) {
                    $guarantor->profile_picture = $guarantorProfilePictures[$key];
                    $guarantor->save();
                }
            }
            DB::commit();

            return $this->success(new DriverResource($driver), 'Driver and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the driver and guarantors.');
        }
    }


    public function updateProfile(Request $request)
    {
        if (Auth::user()->hasRole('driver')) {

            $user = auth()->user(); // Assuming you are using authentication
            // Validate the incoming request data
            $validatedData = $request->validate([
                'full_name' => 'required|string',
                'address' => 'required|string',
                'phone_number' => 'required|string',
                'license_number' => 'required|string',
                'vehicle_type_id' => 'required|string',
            ]);

            // Update user profile data
            $user->update([
                'full_name' => $validatedData['full_name'],
                'address' => $validatedData['address'],
                'phone_number' => $validatedData['phone_number'],
            ]);


            $driver = new Driver([
                'user_id' => $user->id,
                'street' => $request->input('address'),
                'nin_number' => $request->input('nin_number'),
                'license_number' => $request->input('license_number'),
                'vehicle_type_id' => $request->input('vehicle_type_id'),
            ]);



            return $this->success(['user' => new DriverResource($driver)], "Profile updated successfully");
            // return response()->json(['message' => 'Profile updated successfully']);

        } else {
            return $this->error(null, 'user is not a driver', 422);
        }
    }

    public function changeImage(Request $request)
    {


        if (Auth::user()->hasRole('driver')) {

            $user = auth()->user();
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
            ]);

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $imagePath =  $request->image ? $this->saveImage('profile', $request->image, 500, 500) : null;
                $user->update(['imageUrl' => $imagePath]);
                //  $user->driver->update(['profile_picture' => $imagePath]);
            }

            return $this->success(['user' => new DriverResource($user->driver)], "Profile updated successfully");
        } else {
            return $this->error(null, 'user is not a driver', 422);
        }
    }

    /**
     * acceptOrder
     *  this function is for driver manager to accept
     *  order from loadboard or loadbrocast
     * @param  mixed $request
     * @return void
     */
    public function acceptOrder(Request $request)
    {

        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_no' => 'required|string',
                //'driver_id' => 'required',
            ]);

            $loadBoards = LoadBoard::where("order_no", $request->order_no)->whereNull('acceptable_id')
                ->whereNull('acceptable_type')->first();

            if ($loadBoards) {

                $driver = Driver::where("user_id", auth()->id())->first();

                $loadBoards->acceptable_id = $driver->user->id;
                $loadBoards->acceptable_type = get_class($driver->user);
                $loadBoards->status = "processing";

                if ($loadBoards->save()) {
                    //  $loadBoards->order->driver_id = $driver->user->id;
                    // $loadBoards->order->accepted = "Yes";
                    // $loadBoards->order->acceptable_id = $driver->user->id;
                    //  $loadBoards->order->acceptable_type = get_class($driver->user) ;
                    //  $loadBoards->order->placed_by_id = auth()->user()->id;
                    $loadBoards->loadable->status = "processing";
                    $loadBoards->order->save();

                    $message = "You have been accept order with number " . $loadBoards->order->order_no .
                        " to delivery FROM: " . $loadBoards->order->loadable->sender_location . ", TO: " . $loadBoards->order->loadable->receiver_location;
                    $driver->user->notify(new SendNotification($driver->user, $message));
                }

                return new OrderResource($loadBoards->order);
            } else {

                return $this->error([], "This load has already been taken!");
            }
        });
    }

    public function rejectOrder(Request $request)
    {

        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_no' => 'required|string',
                //'driver_id' => 'required',
            ]);

            $loadBoards = LoadBoard::where("order_no", $request->order_no)->where('acceptable_id', auth()->id())->first();

            if ($loadBoards) {

                $driver = Driver::where("user_id", auth()->id())->first();

                $loadBoards->acceptable_id = null;
                $loadBoards->acceptable_type = null;
                $loadBoards->status = "Pending";

                if ($loadBoards->save()) {
                    //   $loadBoards->order->driver_id = null;
                    //    $loadBoards->order->accepted = "No";
                    //   $loadBoards->order->acceptable_id = null;
                    //  $loadBoards->order->acceptable_type = null;
                    //  $loadBoards->order->placed_by_id = auth()->user()->id;
                    $loadBoards->loadable->status = "Pending";
                    $loadBoards->order->save();

                    $message = "You have rejected this load with " . $loadBoards->order->order_no .
                        " to delivery FROM: " . $loadBoards->order->loadable->sender_location . ", TO: " . $loadBoards->order->loadable->receiver_location;
                    $driver->user->notify(new SendNotification($driver->user, $message));
                }

                return new OrderResource($loadBoards->order);
            } else {

                return $this->error([], "This load doesn't belong to this driver");
            }
        });
    }
    public function order(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $driver = LoadBoard::where("acceptable_id", auth()->id())->paginate($perPage);
        //  $order =  Order::where('acceptable_id', $driver->user->id)
        // ->where('acceptable_type', get_class($driver->user))
        // ->paginate($perPage);

        //  $order =  Order::where('driver_id', auth()->id())->paginate($perPage);

        return  LoadBoardResource::collection($driver);
    }


    public function routeBuild(Request $request)
    {

        $route = OrderRoutePlan::where("acceptable_id", auth()->id())->orderby('position')->get();

        return  $route;
    }


    public function storeRouteBuild(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:order_route_plans,id',
            'position' => 'required|integer',
            //  'status' => 'required|in:Pending,Confirmed,Processing,Waiting,out_for_delivery,canceled,returned,Delivered,awaiting_confirmation'
        ]);

        $route = OrderRoutePlan::where("acceptable_id", auth()->id())->where("id", $request->id)->first();

        if (!$route) {
            return response()->json(['error' => 'Route not found'], 404);
        }

        $route->position = $request->position;
        //   $route->status = $request->status;
        $route->save();

        return response()->json(['message' => 'Route updated successfully', 'route' => $route], 200);
    }

    public function acceptLoad(Request  $request) {}

    public function upload_photo(Request $request, string $order_no)
    {
        $validator = Validator::make(
            ['order_no' => $order_no],
            [
                'order_no' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $load = Loadboard::where('order_no', $order_no)->where("acceptable_id", auth()->id())->first();

        if (!$load) {
            return response()->json([
                'error' => "Order not exist or you are not the owner!",
            ], 400);
        }
        $loadable = $load->loadable;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Validate file type
                if (!in_array($file->getClientOriginalExtension(), ['png', 'jpg', 'jpeg'])) {
                    return response()->json(['error' => 'Invalid file type. Only PNG, JPG, and JPEG files are allowed.'], 400);
                }

                $fileDetails = $this->uploadFileWithDetails('load_documents', $file);
                $path = $fileDetails['path'];
                $name = $fileDetails['file_name'];

                $document = new LoadDocument([
                    'name' => $name,
                    'path' => $path,
                ]);

                // Associate the document with the Loadable
                $loadable->loadDocuments()->save($document);
            }

            return response()->json(['message' => 'Images uploaded successfully'], 200);
        } else {
            return response()->json(['error' => 'No images found in the request'], 400);
        }
    }


    //     public function approveOrderStatus(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'admin_approve' => 'required|in:Yes,No',
    //         'order_no' => 'required|string|exists:orders,order_no',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $order = Order::where("order_no",$request->order_no)->where('driver', auth()->id())->first();


    //     $order->admin_approve = $request->admin_approve;

    //     if($order->save()){

    //     $order->user->notify(new SendNotification($order->user, 'Your order status has approved by admin '.$request->payment_status.' '));


    //         return response()->json([
    //             'data' => new OrderResource($order),
    //         ],200);
    //     }else{
    //         return response()->json([
    //             'error' => "unable to update the status.",
    //         ],400);
    //     }


    // }

    public function paymentOrderStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|in:Failed,Paid,Pending',
            'order_no' => 'required|string|exists:orders,order_no',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Order::where("order_no", $request->order_no)->where('driver_id', auth()->id())->first();

        if ($order->payment_type != "offline") {
            return response()->json([
                'error' => "You can only change offline payment or your order",
            ], 400);
        }


        $order->payment_status = $request->payment_status;

        if ($order->save()) {

            $order->user->notify(new SendNotification($order->user, 'Your order status has been changed to!' . $request->payment_status . ' '));

            return response()->json([
                'data' => new OrderResource($order),
            ], 200);
        } else {
            return response()->json([
                'error' => "unable to update the status.",
            ], 400);
        }
    }

    public function loadBoardOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,on_transit,delivered,rejected,delayed',
            'order_no' => 'required|string|exists:load_boards,order_no',
            'status_comment' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loadBoard = LoadBoard::where("order_no", $request->order_no)
            ->where('acceptable_id', auth()->id())
            ->first();

        if (!$loadBoard) {
            return response()->json([
                'error' => "Order not found or order is not yours",
            ], 400);
        }

        if ($loadBoard->status == "delivered") {
            return response()->json(['error' => 'Order already delivered, contact admin if any issues'], 404);
        }

        $loadBoard->status = $request->status;
        $loadBoard->status_comment = $request->status_comment;

        if ($loadBoard->save()) {

            if ($loadBoard->order->driver && $request->status == 'delivered') {
                $this->processPaymentSplits($loadBoard);
            }

            $loadBoard->user->notify(new SendNotification($loadBoard->user, 'Your order status has been changed to: ' . $request->status));

            return response()->json([
                'data' => new LoadBoardResource($loadBoard),
            ], 200);
        } else {
            return response()->json([
                'error' => "Unable to update the status on loadBoard.",
            ], 400);
        }
    }

    private function processPaymentSplits($loadBoard)
    {
        $order = $loadBoard->order;
        $amount = $order->fee;

        // Determine the level and fetch the corresponding percentage configuration
        if ($order->agent_id) {
            $percentageConfig = OrderPriceSetting::where('level', 'level_four')->where('status', 'active')->value('percentage');
        } elseif ($order->driver_manager_id && $order->driver_id) {
            $percentageConfig = OrderPriceSetting::where('level', 'level_three')->where('status', 'active')->value('percentage');
        } elseif ($order->clearing_id) {
            $percentageConfig = OrderPriceSetting::where('level', 'level_two')->where('status', 'active')->value('percentage');
        } else {
            $percentageConfig = OrderPriceSetting::where('level', 'level_one')->where('status', 'active')->value('percentage');
        }

        // Decode JSON percentage configuration
        $percentages = json_decode($percentageConfig, true);

        // Calculate and update each role's wallet based on the percentage
        foreach ($percentages as $role => $percentage) {
            $share = ($percentage / 100) * $amount;

            switch ($role) {
                case 'agent':
                    if ($order->agent_id) {
                        $this->updateUserWallet($order->agent_id, $share, $order->order_no);
                    }
                    break;
                case 'driver_manager':
                    if ($order->driver_manager_id) {
                        $this->updateUserWallet($order->driver_manager_id, $share, $order->order_no);
                    }
                    break;
                case 'clearing_and_forwarding':
                    if ($order->clearing_id) {
                        $this->updateUserWallet($order->clearing_id, $share, $order->order_no);
                    }
                    break;
                case 'driver':
                    if ($order->driver_id) {
                        $this->updateUserWallet($order->driver_id, $share, $order->order_no);
                    }
                    break;
                case 'system':
                    // Assuming the system wallet is handled internally or via a specific system user ID
                    $this->updateUserWallet(1, $share, $order->order_no);
                    break;
            }
        }
    }

    private function updateUserWallet($userId, $amount, $orderNo)
    {
        $user = User::find($userId);

        if (!$user) {
            Log::error('User not found for ID: ' . $userId);
            return;
        }

        WalletService::updateWallet($user, [
            'amount' => $amount,
            'type' => 'credit',
            'payment_type' => 'wallet',
            'description' => "Payment for Order No: " . $orderNo,
        ]);
    }
    public function deleteAccount(Request $request)
    {
        try {
            DB::beginTransaction();

            // Find the user
            $user = User::findOrFail(auth()->id());

            $driver = Driver::where('user_id', auth()->id())->first();

            if ($driver) {
                // Delete the driver
                $driver->delete();
            }

            // Delete the user
            $user->delete();

            DB::commit();

            return $this->success(null, 'User and associated driver deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while deleting the user and associated driver.');
        }
    }
}
