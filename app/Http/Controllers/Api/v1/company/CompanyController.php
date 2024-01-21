<?php

namespace App\Http\Controllers\Api\v1\Company;

use App\Models\User;
use App\Models\Order;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\Company;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TruckResource;
use App\Http\Resources\DriverResource;
use App\Jobs\SendLoginNotificationJob;
use App\Http\Resources\CompanyResource;
use App\Notifications\SendNotification;
use App\Http\Resources\LoadBoardResource;


class CompanyController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $company = Company::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('street', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return CompanyResource::collection($company);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::firstOrNew(['email' => $request->input('email')]);

            $ref_by = null;

            if ($request->has('ref_by')) {
                $ref_by = User::where("referral_code", $request->ref_by)->first();
            }


            if (!$user->exists) {
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->address = $request->input('address');
                $user->ref_by = $ref_by ? $ref_by->id : null;
                $user->referral_code = $request->referral_code ?? generateReferralCode();
                $user->phone_number = $request->input('phone_number');
                $password  = Str::random(16);
                $user->password = Hash::make($password);
                $user->imageUrl = $this->uploadFile('company/company_images', $request->file('company_logo'));
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );
            }

            $role = Role::find(10);
            if ($role) {
                $user->user_type = Str::slug($role->name, "_"); //str_replace(' ', '_', $role->name);;
                $user->role_id = $role->id;
                $user->role = $role->name;
                $user->assignRole($role);
            }
            $user->save();
            $company = new Company([
                'user_id' => $user->id,
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'truck_type' => $request->input('type_of_truck'),
                'number_of_drivers' => $request->input('number_of_drivers'),
                'number_of_trucks' => $request->input('number_of_trucks'),
                'status' => 'Waiting',
                'lga' => $request->input('lga'),
                'state_of_residence' => $request->input('state_of_residence'),
                'city_of_residence' => $request->input('city_of_residence'),
            ]);

            $company->company_logo = $this->uploadFile('company/company_images', $request->file('company_logo'));
            $company->cac_documents = $this->uploadFile('company/company_documents', $request->file('cac_documents'));

            $company->save();

            DB::commit();

            return $this->success(new CompanyResource($company), 'Company registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the Company.');
        }
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


     /**
     * orderAssign
     * this function assign order to driver
     * @param  mixed $request
     * @return void
     */
    public function orderAssign(Request $request){

        return DB::transaction(function () use ($request) {

        $request->validate([
            'order_id' => 'required',
            'driver_id' => 'required',
        ]);

        $driver = Driver::find($request->driver_id);
        $order =  Order::where("id",$request->order_id)->where("driver_id",null)->first();

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
    public function acceptOrder(Request $request){

        return DB::transaction(function () use ($request) {

        $request->validate([
            'load_board_id' => 'required',
            //'driver_id' => 'required',
        ]);

        $loadBoards = LoadBoard::where("id",$request->load_board_id)->whereNull('acceptable_id')
        ->whereNull('acceptable_type')->first();

        if($loadBoards){

            $driverManger = Company::where("user_id",auth()->id())->first();

            $loadBoards->acceptable_id = $driverManger->id;
            $loadBoards->acceptable_type = get_class($driverManger) ;

            $loadBoards->loadable->status = "Processing";
            $loadBoards->save();

            return new LoadBoardResource($loadBoards);
        }else{

            return $this->error([
            ], "This load has already been taken!");
        }

    });

    }

    public function driver(Request $request)
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

    public function truck(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $truck = Truck::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('email', 'like', "%{$key}%");
            })->orWhere('plate_number', 'like', "%{$key}%")
            ->orWhere('truck_location', 'like', "%{$key}%")
            ->orWhere('truck_name', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return TruckResource::collection($truck);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->user()->delete();
        $request->user()->company()->delete();
    }


    public function createUser(Request $request)
    {

        if (!Auth::user()->hasRole('Company Transport')) {

            return response()->json(['message' => 'You dont have permission to create or updated user'], 422);
        }

        // Validate the request data
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|string',
            'phone_number' => 'required|numeric',
            'role' => 'required|in:super_admin,admin', // 1 for super admin, 2 for admin
        ]);

        // Check if the user already exists by email
        $user = User::where('email', $request->input('email'))->first();

        $role = $role = Role::find(10);
        if ($user) {
            // User already exists; update their role
            $user->syncRoles([$role]);

            return response()->json(['message' => 'User role updated successfully'], 200);
        }

        // Create a new user
        $user = new User();
        $user->email = $request->input('email');
        $user->full_name = $request->input('full_name');
        $user->address = $request->input('address');
        $user->phone_number = $request->input('phone_number');
        $user->user_created_by = Auth::user()->id;
        $user->role =$request->input('role');
        $user->user_type = Str::slug($role->name, "_"); //str_replace(' ', '_', $role->name);
        $password  = Str::random(16);
        $user->password = Hash::make($password);
        //$user->user_type = 'company_transporter_super';
        $user->save();

        $role =  $role = Role::find(10); //$request->input('role') == 1 ? 'super-admin' : 'admin';
        $data = [
            "full_name" => $request->input('full_name'),
            "password" => $password,
            "message" => "Your account as a/an ".$role->name." has been created",
        ];
        Mail::to($user->email)->send(
            new SendPasswordMail($data)
        );
        // Assign the user's role
        $user->assignRole($role);

        return response()->json(['message' => 'User created successfully', 'user' => new UserResource($user)], 201);
    }
    public function myUsers()
    {
        // Check if the logged-in user has the 'Company Transport' role
        if (!Auth::user()->hasRole('Company Transport')) {
            return response()->json(['message' => 'You do not have permission to access this resource'], 403);
        }

        // Fetch the list of users registered under the logged-in user
        $myUsers = User::where('user_created_by', Auth::user()->id)->get();

        return response()->json(['message' => 'List of users registered under ' . Auth::user()->full_name, 'users' => UserResource::collection($myUsers)], 200);
    }


    public function changeRole(Request $request)
    {
        // Check if the logged-in user has the 'Company Transport' role
        if (!Auth::user()->hasRole('Company Transport')) {
            return response()->json(['message' => 'You do not have permission to access this resource'], 403);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:10,2', // 1 for super admin, 2 for admin
        ]);

        // Fetch the list of users registered under the logged-in user
        $user = User::where(['user_created_by' => Auth::user()->id,'email'=>$request->email])->first();

        $role = $role = Role::find($request->input('role')); //$request->input('role') == 1 ? 'super-admin' : 'admin';
        if ($user) {
            // User already exists; update their role
            $user->user_type = Str::slug($role->name, "_");
            $user->save();
            $user->syncRoles([$role]);
            $message ="Your Role has been changed to ".$role->name;
              // $user->notify(new SendNotification($user, $message));
        dispatch(new SendLoginNotificationJob($user, $message));

            return response()->json(['message' => 'User role updated successfully','user'=> new UserResource($user)], 200);
        }else{

            return response()->json(['message' => 'User not found!'], 404);
        }
    }




    public function broadcast(Request $request)
    {
        $query = LoadBoard::whereIn('load_type_id', [1, 2])->orWhere("acceptable_id", auth()->id())->orWhere("acceptable_id", null)->orderBy('created_at', 'desc');

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

    public function singleBroadcast(Request $request,$id)
    {

        $query = LoadBoard::where("id",$id)->whereIn('load_type_id', [1, 2])->orWhere("acceptable_id", auth()->id())->orWhere("acceptable_id", null)->orderBy('created_at', 'desc');

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

}
