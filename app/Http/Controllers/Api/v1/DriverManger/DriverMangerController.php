<?php

namespace App\Http\Controllers\Api\v1\DriverManger;

use App\Models\User;
use App\Models\Order;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\Guarantor;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use App\Models\DriverManger;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Doctrine\DBAL\DriverManager;
use App\Mail\DriverManagerRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TruckResource;
use App\Http\Resources\DriverResource;
use App\Jobs\SendLoginNotificationJob;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\LoadBoardResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DriverMangerRequest;
use App\Http\Resources\DriverMangerResource;

class DriverMangerController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
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
        })->where("have_motor","No")
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($driver);
    }


    public function my_info(){

        return new DriverResource(DriverManger::find(auth()->id()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverMangerRequest $request)
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
                $user->ref_by = $ref_by ? $ref_by->id : null;
                $user->referral_code = $request->referral_code ?? generateReferralCode();
                $user->address = $request->input('address');
                $user->phone_number = $request->input('phone_number');
                $password  = Str::random(16);
                $user->password = $password;
                $user->user_type = 'driver_manager';
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );
                $role = Role::where('name', 'Agent')->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }

            $driverManager = new DriverManger([
                'user_id' => $user->id,
                'phone_number' => $request->input('phone_number'),
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'status' => 'Pending',
                'business_name' =>  $request->input('business_name'),
                'lga' => $request->input('lga'),
               // 'state_of_residence' => $request->input('state_of_residence'),
                //'city_of_residence' => $request->input('city_of_residence'),
                // Add other agent fields here
            ]);

            $driverManager->office_front_image = $this->uploadFile('driver_manager', $request->file('office_front_image'));
            $driverManager->inside_office_image = $this->uploadFile('driver_manager', $request->file('inside_office_image'));
            $driverManager->cac_certificate = $this->uploadFile('driver_manager', $request->file('cac_certificate'));

            $driverManager->save();

            $guarantorProfilePictures = [];

            foreach ($request->input('guarantors') as $key => $guarantorData) {
                $guarantor = new Guarantor([
                    'full_name' => $guarantorData['full_name'],
                    'phone_number' => $guarantorData['phone_number'],
                    'street' => $guarantorData['street'],
                    'state' => $guarantorData['state'],
                    'lga' => $guarantorData['lga'],
                    'email' => $guarantorData['email'],
                ]);

                $guarantor->loadable()->associate($driverManager);

                $guarantorProfilePictures[] = $this->uploadFile('driver_manager/guarantor_images', $request->file("guarantors.$key.profile_picture"));

                $driverManager->guarantors()->save($guarantor);
            }

            foreach ($driverManager->guarantors as $key => $guarantor) {
                $guarantor->profile_picture = $guarantorProfilePictures[$key];
                $guarantor->save();
            }

            DB::commit();

            return $this->success( new DriverMangerResource($driverManager), 'Driver Manager and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the driver Manager and guarantors.');
        }
    }


    public function my_drivers(Request $request)
    {

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%")
                           ->where('user_created_by', auth()->id());
            })
            ->where("have_motor", "No")
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($drivers);
    }


public function available_drivers(Request $request)
{
    $key = $request->input('search');
    $perPage = $request->input('per_page', 10);

     $drivers = Driver::with('user')->get();
        // ->whereHas('user', function ($userQuery) use ($key) {
        //     $userQuery->where('full_name', 'like', "%{$key}%")
        //               ->whereNull('user_created_by');
        // })
        // ->where("have_motor", "No")
        // ->latest()
        // ->paginate($perPage);

    return DriverResource::collection($drivers);
}



    public function available_truck(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $truck = Truck::whereHas('user', function ($userQuery) use ($key) {
            $userQuery->where('full_name', 'like', "%{$key}%")
            ->whereNull('user_created_by');
        })
            ->latest()
            ->paginate($perPage);

        return TruckResource::collection($truck);
    }


    public function my_truck(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $truck = Truck::whereHas('user', function ($userQuery) use ($key) {
            $userQuery->where('full_name', 'like', "%{$key}%")
            ->where('user_created_by', auth()->id());
            })
            ->latest()
            ->paginate($perPage);

        return TruckResource::collection($truck);
    }


    public function order(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::where(function ($q) use ($key) {
            $q->where('have_motor', 'like', "%{$key}%");
            $q->orWhere('nin_number', 'like', "%{$key}%");
            $q->orWhereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            });
        })->where("have_motor", "No")
            ->whereHas('acceptedOrders', function ($orderQuery) use ($key) {
                $orderQuery->where('amount', '>=', "%{$key}%");
                $orderQuery->orWhere('order_no', 'like', "%{$key}%");

            })
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($drivers);
    }

    public function broadcast(Request $request)
    {
        $query = LoadBoard::whereIn('load_type_id', [1, 2])->orWhere("acceptable_id", null)->orderBy('created_at', 'desc');
        // $query = LoadBoard::orWhere("acceptable_id", auth()->id())->whereIn('load_type_id', [1, 2])->orWhere("acceptable_id", null)->orderBy('created_at', 'desc');

        // Filter by Order Number
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        // Add more filters as needed

        $perPage = $request->input('per_page', 10); // Number of items per page, defaulting to 10.

        // Use the paginate method to paginate the results
        $loadBoards = $query->latest()->paginate($perPage);

        return LoadBoardResource::collection($loadBoards);
    }

    public function singleBroadcast(Request $request,$id)
    {

        $query = LoadBoard::where("id",$id)->whereIn('load_type_id', [1, 2])->Where("acceptable_id", null)->orderBy('created_at', 'desc');
        // $query = LoadBoard::where("id",$id)->orWhere("acceptable_id", auth()->id())->whereIn('load_type_id', [1, 2])->orWhere("acceptable_id", null)->orderBy('created_at', 'desc');

        // Filter by Order Number
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        $perPage = $request->input('per_page', 10); // Number of items per page, defaulting to 10.

        // Use the paginate method to paginate the results
        $loadBoards = $query->latest()->paginate($perPage);

        return LoadBoardResource::collection($loadBoards);
    }

    /**
     * orderAssign
     * this function assign order to driver
     * @param  mixed $request
     * @return void
     */
    public function orderAssign(Request $request){

        return DB::transaction(function () use ($request) {

        $request->validate([
            'order_no' => 'required',
            'driver_id' => 'required',
        ]);

        $driver = Driver::find($request->driver_id);
        $order =  Order::where("order_no",$request->order_no)->where("driver_id",null)->first();

        if($order){
         //   return $order->loadable->state;
            $order->driver_id = $driver->id;
            $order->acceptable_id = $driver->id;
            $order->acceptable_type = get_class($driver) ;
            $order->placed_by_id = auth()->user()->id;
            $order->save();
            $message ="You have been assign an order with number ". $order->order_no. " to delivery from: ".$order->loadable->sender_location." To: ".$order->loadable->receiver_location;
            $driver->user->notify(new SendNotification($driver->user, $message));

            return $this->success([
                new OrderResource($order),
            ]);


        }else{
             return $this->error([
            ], "Order already assign or doesn't exist!");
        }

    });

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
                'load_board_id' => 'required|exists:load_boards,id',
            ]);

            $loadBoard = LoadBoard::find($request->load_board_id);

            if (!$loadBoard) {
                return response()->json(['message' => 'Order or load not found'], 403);
            }

            if (!$loadBoard->acceptable_id && !$loadBoard->acceptable_type) {
                $driverManager = DriverManger::where("user_id", auth()->id())->first();

                if ($driverManager) {
                    $loadBoard->acceptable_id = $driverManager->id;
                    $loadBoard->acceptable_type = get_class($driverManager);
                    $loadBoard->status = "Processing";

                    // if ($loadBoard->loadable && $loadBoard->loadable->status !== "Processing") {
                    //     $loadBoard->loadable->save();
                    //     $loadBoard->loadable->status = "Processing";
                    // }

                    $loadBoard->save();

                    return new LoadBoardResource($loadBoard);
                } else {
                    return $this->error([], "Driver manager not found!");
                }
            } else {
                return $this->error([], "This load has already been taken!");
            }
        });
    }


    public function sendRequest(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "role_id" => "required|exists:roles,id"
        ]);

        $driverManager = User::role('Driver Manager')->where('id', auth()->id())->first();

        // Check if the current user is a driver manager
        if (!$driverManager) {
            return response()->json(['message' => 'You are not authorized to send requests.'], 403);
        }

        // Check if the target user exists and is a driver or truck owner
        $targetUser = User::where('id', $request->user_id)->whereNull('user_created_by')->first();

        // Ensure $targetUser is not null before accessing its properties
        if (!$targetUser) {
            return response()->json(['message' => 'No User is available.'], 400);
        }

      //  return $targetUser->roles;
        if (!$targetUser->hasAnyRole(['Driver', 'Truck'])) {
            return response()->json(['message' => 'This user is not driver or truck role.'], 400);
        }

        // Send request and set the manager_request flag

        $message = "".auth()->user()->full_name." ";
        // $user->notify(new SendNotification($user, $message));
    //    dispatch(new SendLoginNotificationJob($targetUser, $message));

         Mail::to($targetUser)->send(new DriverManagerRequest($targetUser, $message));

        $targetUser->update(['manager_request' => 1]);

        return response()->json(['message' => 'Request sent successfully.']);
    }

    public function updateRequest(Request $request, $driverId, $managerId, $status)
    {
        $validator = Validator::make([
            'driverId' => $driverId,
            'managerId' => $managerId,
        ], [
            'driverId' => 'required|exists:users,id',
            'managerId' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->away('https://talosmart-monodone-frontend.vercel.app/monolog/?feedback=error')->withErrors($validator);
        }

        $driver = User::find($driverId);
        $manager = User::find($managerId);

        $driver->manager_request = (($status=="accepted") ? 0 :1 );
        $driver->user_created_by =  (($status=="accepted") ? $manager->id : null );

        if ($driver->save()) {
            return redirect()->away("https://talosmart-monodone-frontend.vercel.app/monolog/?feedback=$status");
        } else {
            // Handle the case where the save operation fails
            return redirect()->away('https://talosmart-monodone-frontend.vercel.app/monolog/?feedback=error')->withErrors(['message' => 'Failed to update user']);
        }
    }

}
