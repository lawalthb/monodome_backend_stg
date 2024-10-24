<?php

namespace App\Http\Controllers\Api\v1\Company;

use App\Models\User;
use App\Models\Order;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\Company;
use App\Models\LoadBulk;
use App\Models\LoadType;
use App\Models\LoadBoard;
use App\Models\LoadPackage;
use Illuminate\Support\Str;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
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
use App\Http\Requests\LoadBulkRequest;
use App\Http\Resources\DriverResource;
use App\Jobs\SendLoginNotificationJob;
use App\Http\Resources\CompanyResource;
use App\Notifications\SendNotification;
use App\Http\Resources\LoadBulkResource;
use App\Http\Requests\LoadPackageRequest;
use App\Http\Resources\LoadBoardResource;
use App\Http\Resources\LoadPackageResource;


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
                $userQuery->where('full_name', 'like', "%{$key}%")->where('user_created_by', auth()->id());
            })->orWhere('street', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return CompanyResource::collection($company);
    }


    public function my_info()
    {

        if (auth()->user()->user_created_by != null) {
            // dd(auth()->user()->user_created_by,"you are under a company");
            //  return Company::where("user_id",auth()->user()->user_created_by)->first();
            return new CompanyResource(Company::where("user_id", auth()->user()->user_created_by)->first());
        }
        // dd(auth()->user()->user_created_by,"you are a admin");
        return new CompanyResource(Company::where("user_id", auth()->user()->id)->first());
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
    public function orderAssign(Request $request)
    {

        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_id' => 'required',
                'driver_id' => 'required',
            ]);

            $driver = Driver::find($request->driver_id);
            $order =  Order::where("id", $request->order_id)->where("driver_id", null)->first();

            if ($order) {
                //   return $order->loadable->state;
                $order->driver_id = $driver->id;
                $order->acceptable_id = $driver->id;
                $order->acceptable_type = get_class($driver);
                $order->placed_by_id = auth()->user()->id;
                $order->save();
                $message = "You have been assign an order with number " . $order->order_no . " to delivery from: " . $order->loadable->sender_location . " To: " . $order->loadable->receiver_location;
                $driver->user->notify(new SendNotification($driver->user, $message));

                return $this->success([
                    new OrderResource($order),
                ]);
            } else {
                return $this->error([], "Order already assign or doesn't exist!");
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
                'load_board_id' => 'required',
                //'driver_id' => 'required',
            ]);

            $loadBoards = LoadBoard::where("id", $request->load_board_id)->whereNull('acceptable_id')
                ->whereNull('acceptable_type')->first();

            if ($loadBoards) {

                $driverManger = Company::where("user_id", auth()->id())->first();

                $loadBoards->acceptable_id = $driverManger->id;
                $loadBoards->acceptable_type = get_class($driverManger);

                $loadBoards->loadable->status = "Processing";
                $loadBoards->save();

                return new LoadBoardResource($loadBoards);
            } else {

                return $this->error([], "This load has already been taken!");
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
                $userQuery->where('full_name', 'like', "%{$key}%")
                    ->where('user_created_by', auth()->id());
            })->orWhere('license_number', 'like', "%{$key}%");
        })->where("have_motor", "No")
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
        $user->role = $request->input('role');
        $user->user_type = Str::slug($role->name, "_"); //str_replace(' ', '_', $role->name);
        $password  = Str::random(16);
        $user->password = Hash::make($password);
        //$user->user_type = 'company_transporter_super';
        $user->save();

        $role =  $role = Role::find(10); //$request->input('role') == 1 ? 'super-admin' : 'admin';
        $data = [
            "full_name" => $request->input('full_name'),
            "password" => $password,
            "message" => "Your account as a/an " . $role->name . " has been created",
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

    public function delete_user()
    {
        // Check if the logged-in user has the 'Company Transport' role
        if (!Auth::user()->hasRole('Company Transport')) {
            return response()->json(['message' => 'You do not have permission to access this resource'], 403);
        }

        // Fetch the list of users registered under the logged-in user
        $myUsers = User::where('user_created_by', Auth::user()->id)->delete();

        if ($myUsers) {

            return response()->json(['message' => 'User deleted'], 200);
        } else {

            return response()->json(['message' => 'Unable to delete user'], 400);
        }
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
        $user = User::where(['user_created_by' => Auth::user()->id, 'email' => $request->email])->first();

        $role = $role = Role::find($request->input('role')); //$request->input('role') == 1 ? 'super-admin' : 'admin';
        if ($user) {
            // User already exists; update their role
            $user->user_type = Str::slug($role->name, "_");
            $user->save();
            $user->syncRoles([$role]);
            $message = "Your Role has been changed to " . $role->name;
            // $user->notify(new SendNotification($user, $message));
            dispatch(new SendLoginNotificationJob($user, $message));

            return response()->json(['message' => 'User role updated successfully', 'user' => new UserResource($user)], 200);
        } else {

            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    public function broadcast(Request $request)
    {
        // $query = LoadBoard::whereIn('load_type_id', [1, 2])->orWhere("acceptable_id", auth()->id())->orWhere("acceptable_id", null)->orderBy('created_at', 'desc');
        $query = LoadBoard::whereIn('load_type_id', [1, 2])->where("acceptable_id", null)->orderBy('created_at', 'desc');

        // Filter by Order Number
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        $perPage = $request->input('per_page', 10);

        $loadBoards = $query->paginate($perPage);

        return LoadBoardResource::collection($loadBoards);
    }

    public function singleBroadcast(Request $request, $id)
    {

        // $query = LoadBoard::where("id",$id)->whereIn('load_type_id', [1, 2])->orWhere("acceptable_id", auth()->id())->orWhere("acceptable_id", null)->orderBy('created_at', 'desc');
        $query = LoadBoard::where("id", $id)->whereIn('load_type_id', [1, 2])->where("acceptable_id", null)->orderBy('created_at', 'desc');

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
     * sendRequest
     * this function send request to driver or truck owners
     * @param  mixed $request
     *
     */
    public function sendRequest(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "role_id" => "required|exists:roles,id"
        ]);

        $driverOrTruck = User::role('Company Transport')->where('id', auth()->id())->first();

        // Check if the current user is a Company Transport
        if (!$driverOrTruck) {
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
        $targetUser->update(['manager_request' => 1]);

        return response()->json(['message' => 'Request sent successfully.']);
    }


    public function remove_driver(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "role_id" => "required|exists:roles,id"
        ]);

        $driverOrTruck = User::role('Company Transport')->where('id', auth()->id())->first();

        // Check if the current user is a Company Transport
        if (!$driverOrTruck) {
            return response()->json(['message' => 'You are not authorized to send requests.'], 403);
        }

        // Check if the target user is yours
        $targetUser = User::where('id', $request->user_id)->where('user_created_by', auth()->id())->first();

        // Ensure $targetUser is not null before accessing its properties
        if (!$targetUser) {
            return response()->json(['message' => 'User is not yours.'], 400);
        }

        //  return $targetUser->roles;
        if (!$targetUser->hasAnyRole(['Driver', 'Truck'])) {
            return response()->json(['message' => 'This user is not driver or truck role.'], 400);
        }

        // Send request and set the manager_request flag
        $targetUser->update(['user_created_by' => null]);

        return response()->json(['message' => 'User remove successfully.']);
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

    public function available_drivers(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::whereHas('user', function ($userQuery) use ($key) {
            $userQuery->where('full_name', 'like', "%{$key}%")
                ->whereNull('user_created_by');
        })
            ->where("have_motor", "No")
            ->where("status", "Confirmed")
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($drivers);
    }

    public function my_drivers(Request $request)
    {

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::whereHas('user', function ($userQuery) use ($key) {
            $userQuery->where('full_name', 'like', "%{$key}%")
                ->where('user_created_by', auth()->id());
        })
            //   ->where("have_motor", "No")
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($drivers);
    }


    public function createTruck(Request $request)
    {
        try {
            DB::beginTransaction();

            // Check if the email or phone number already exists
            $existingUser = User::where('email', $request->input('email'))
                ->orWhere('phone_number', $request->input('phone_number'))
                ->first();

            if ($existingUser) {
                return $this->error('User with the provided email or phone number already exists');
            }

            // Create or update the user
            $user = User::firstOrNew(['email' => $request->input('email')]);

            if (!$user->exists) {
                // User doesn't exist, so create a new user
                $user->full_name = $request->input('business_name');
                $user->email = $request->input('email');
                $user->phone_number = $request->input('phone_number');
                $password = Str::random(16);
                $user->password = $password;
                $user->user_created_by = Auth::user()->id;
                $user->ref_by =  Auth::user()->id;
                $user->user_type = 'truck';
                $user->save();

                $role = Role::where('name', 'Truck')->first();
                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "Your account as a/an " . $role->name . " has been created",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );

                if ($role) {
                    $user->assignRole($role);
                }
            }

            // Create or update the truck
            $truck = Truck::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone_number' => $request->input('phone_number'),
                    'state_id' => $request->input('state_id'),
                    'street' => $request->input('street'),
                    'lga' => $request->input('lga'),
                    'status' => 'Pending',
                    'truck_name' => $request->input('truck_name'),
                    'truck_type' => $request->input('truck_type'),
                    'truck_location' => $request->input('truck_location'),
                    'truck_make' => $request->input('truck_make'),
                    'plate_number' => $request->input('plate_number'),
                    'cac_number' => $request->input('cac_number'),
                    'truck_description' => $request->input('truck_description'),
                    'business_name' => $request->input('business_name'),
                ]
            );


            // Handle document uploads
            if ($request->input('profile_picture')) {
                // Save the profile picture
                $truck->profile_picture = $this->uploadFile('truck/truck_images', $request->file('profile_picture'));
                $truck->save();
            }

            DB::commit();

            return $this->success(new TruckResource($truck), 'Truck registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the truck');
        }
    }

    public function createDriver(Request $request)
    {

        try {
            DB::beginTransaction();

            // Check if the email or phone number already exists
            $existingUser = User::where('email', $request->input('email'))
                ->orWhere('phone_number', $request->input('phone_number'))
                ->first();

            if ($existingUser) {
                return $this->error('User with the provided email or phone number already exists');
            }


            $user = User::firstOrNew(['email' => $request->input('email')]);


            if ($request->has('ref_by')) {
                $ref_by = User::where("referral_code", $request->ref_by)->first();
            }

            if (!$user->exists) {
                // User doesn't exist, so create a new user
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->address = $request->input('address');
                $user->ref_by =  Auth::user()->id;
                $user->user_created_by = Auth::user()->id;
                $user->referral_code = $request->referral_code ?? generateReferralCode();
                $password  = Str::random(16);
                $user->phone_number = $request->input('phone_number');
                $user->password = Hash::make($password);
                $user->user_type = 'driver';
                $user->save();


                $role = Role::where('name', 'Driver')->first();

                if ($role) {
                    $user->assignRole($role);
                }

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "Your account as a/an " . $role->name . " has been created",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );

                //only send password to drivers that doesnt have motor
                //    if($request->input('have_motor') =="Yes"){
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );

                // }


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

            // $driver->registration_documents = $this->uploadFile('agent/agent_documents', $request->file('registration_documents'));

            $driver->save();

            if ($request->hasFile('proof_of_license')) {

                $driver->proof_of_license = $this->uploadFile('driver/driver_images', $request->file('proof_of_license'));
                $driver->profile_picture = $this->uploadFile('driver/driver_images', $request->file('profile_picture'));
            }

            DB::commit();

            return $this->success(new DriverResource($driver), 'Driver and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the driver and guarantors.');
        }
    }


    public function moveTruckToWorkshop(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'moveIt' => 'required|in:Yes,No',
            'workshop_mode_reason' => 'required_if:moveIt,Yes',
        ]);

        $key = $validatedData['user_id'];

        $truck = Truck::whereHas('user', function ($userQuery) use ($key) {
            $userQuery->where('id', $key)
                ->where('user_created_by', auth()->id());
        })->first();

        if (!$truck) {
            return response()->json(['error' => 'Truck not found for the specified user id.'], 404);
        }

        $truck->workshop_mode = $validatedData['moveIt'];
        $truck->workshop_mode_reason = $validatedData['workshop_mode_reason'];
        $truck->save();

        return new TruckResource($truck);
    }


    public function truckInWorkshop(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $truck = Truck::where('workshop_mode', 'Yes')->whereHas('user', function ($userQuery) use ($key) {
            $userQuery->where('full_name', 'like', "%{$key}%")
                ->where('user_created_by', auth()->id());
        })
            ->latest()
            ->paginate($perPage);

        return TruckResource::collection($truck);
    }

    public function driverWithTruck(Request $request)
    {

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::whereHas('user', function ($userQuery) use ($key) {
            $userQuery->where('full_name', 'like', "%{$key}%")
                ->where('user_created_by', auth()->id());
        })->whereHas('trucks')
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($drivers);
    }


    public function assignDriverToTruck(Request $request)
    {
        $request->validate([
            'truck_id' => 'required|exists:trucks,user_id',
            'driver_id' => 'required|exists:users,id',
        ]);

        $driver = User::where("id", $request->driver_id)->where('user_created_by', auth()->id())->first();
        $truck = Truck::where("user_id", $request->truck_id)->first();

        if (!$driver) {
            return $this->error([], "Driver not found or is not under you!");
        }

        if (!$truck) {
            return $this->error([], "Truck not found or is not under you!");
        }

        $truck->driver_user_id = $driver->id;
        $truck->save();

        return $this->success([
            new TruckResource($truck),
        ]);
    }


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
                    'user_id' => $request->user()->id,
                    // 'delivery_fee' => $request->delivery_fee,
                    'weight' => $request->weight,
                    'is_private' => "Yes",
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
                'user_id' => $request->user()->id,
                // 'delivery_fee' => $request->delivery_fee,
                'weight' => $request->weight,
                'is_private' => "Yes",
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
        $order = Order::where("order_no", $request->order_no)->where("payment_status", "Pending")->first();

        if (!$order) {
            return $this->error([], "Order not found");
        }

        $driver = User::where("id", $request->driver_id)->where("user_created_by", Auth::user()->id)->first();

        if (!$driver) {
            return $this->error([], "driver not found!");
        }
        $truck = Truck::where("driver_user_id", $driver->id)->first();

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


    public function deleteAccount(Request $request)
    {
        try {
            DB::beginTransaction();

            // Find the user
            $user = User::findOrFail(auth()->id());

            $company = Company::where('user_id', auth()->id())->first();

            if ($company) {
                // Delete the company
                $company->delete();
            }

            // Delete the user
            $user->delete();

            DB::commit();

            return $this->success(null, 'User and associated company deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while deleting the user and associated company.');
        }
    }
}
