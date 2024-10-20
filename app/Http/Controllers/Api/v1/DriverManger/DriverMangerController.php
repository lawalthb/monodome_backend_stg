<?php

namespace App\Http\Controllers\Api\v1\DriverManger;

use in;
use App\Models\User;
use App\Models\Order;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\Guarantor;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use App\Models\DriverManger;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Mail\SendUserPassword;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Doctrine\DBAL\DriverManager;
use App\Mail\DriverManagerRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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

    use ApiStatusTrait, FileUploadTrait;

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
        })->where("have_motor", "No")
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($driver);
    }


    public function my_info()
    {

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

            return $this->success(new DriverMangerResource($driverManager), 'Driver Manager and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the driver Manager and guarantors.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeNew(DriverMangerRequest $request)
    {


        try {
            DB::beginTransaction();

            // Check if a user with the same email exists and if their role_id is 9
            $existingUserWithRole9 = User::where('email', $request->input('email'))->where('role_id', 9)->first();
            if ($existingUserWithRole9) {
                return $this->error('A user with this email and role cannot be registered again.');
            }

            // Check if user with the same email exists but has a different role_id
            $existingUser = User::where('email', $request->input('email'))->first();

            // Initialize the referral user (ref_by)
            $ref_by = null;
            if ($request->has('ref_by')) {
                $ref_by = User::where('referral_code', $request->input('ref_by'))->first();
            }


            if (!$existingUser) {
                // User doesn't exist, so create a new user
                $user = new User();
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->ref_by = $ref_by ? $ref_by->id : null; // Set the ref_by user ID
                $user->referral_code = $request->referral_code ?? generateReferralCode();
                $user->address = $request->input('address');
                $user->phone_number = $request->input('phone_number');
                $password  = Str::random(16);
                $user->password = bcrypt($password); // Make sure to hash the password
                $user->user_type = 'driver_manager';
                $user->role_id = 9; // Set the role_id to 9 for driver managers
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];

                $role = Role::where('name', 'Driver Manager')->first();

                Mail::to($user->email)->send(new SendPasswordMail($data));
                if ($role) {
                    $user->assignRole($role);
                }
            } else {
                // User exists but has a different role, so you can proceed
                $user = $existingUser; // Use the existing user
            }

            $driverManager = new DriverManger([
                'user_id' => $user->id,
                'phone_number' => $request->input('phone_number'),
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'status' => 'Pending',
                'business_name' =>  $request->input('business_name'),
                'lga' => $request->input('lga'),
                'company_name' =>  $request->input('company_name'),
                'company_state' =>  $request->input('company_state'),
                'company_lga' =>  $request->input('company_lga'),
            ]);

            $driverManager->profile_picture = $this->uploadFile('driver_manager', $request->file('profile_picture'));

            $driverManager->save();

            DB::commit();

            return $this->success(new DriverMangerResource($driverManager), 'Driver Manager and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the driver Manager and guarantors.');
        }
    }


    public function storeDriver(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'street' => 'required|string|max:255',
            'state_id' => 'required|numeric',
            'lga' => 'required|string|max:255',
            'nin_number' => 'nullable',
            'license_number' => 'nullable',
            'have_motor' => 'required|in:Yes,No',
            'guarantors.*.full_name' => 'nullable|string|max:255',
            'guarantors.*.email' => 'nullable|email',
            'guarantors.*.phone_number' => 'nullable|string|max:15',
            'guarantors.*.street' => 'nullable|string|max:255',
            'guarantors.*.state' => 'nullable|numeric',
            'guarantors.*.lga' => 'nullable|string|max:255',
            // 'guarantors.*.state_of_residence' => 'nullable|numeric',
            // 'guarantors.*.city_of_residence' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Generate a random password
            $password = Str::random(10);

            // Create the user
            $user = User::create([
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'password' => Hash::make($password),
                'user_created_by' => auth()->user()->id,
                'role_id' => 8,
                'role' => 'driver',
                'referral_code' => generateReferralCode(),
                'user_type' => 'driver',
                'ref_by' => auth()->user()->id,
                'status' => 'Pending',
            ]);

            // Create the driver details
            $driver = Driver::create([
                'uuid' => (string) Str::uuid(),
                'user_id' => $user->id,
                'state_id' => $request->input('state_id'),
                'have_motor' => $request->input('have_motor'),
                'street' => $request->input('street'),
                'lga' => $request->input('lga'),
                'nin_number' => $request->input('nin_number'),
                'license_number' => $request->input('license_number'),
                'status' => 'Pending',
            ]);

            // Insert guarantors if needed
            foreach ($request->input('guarantors', []) as $guarantor) {
                // Assuming you have a Guarantor model and relationship with Driver
                $driver->guarantors()->create([
                    'full_name' => $guarantor['full_name'],
                    'email' => $guarantor['email'],
                    'phone_number' => $guarantor['phone_number'],
                    'street' => $guarantor['street'],
                    'state' => $guarantor['state'],
                    'lga' => $guarantor['lga'],
                    // 'state_of_residence' => $guarantor['state_of_residence'],
                    // 'city_of_residence' => $guarantor['city_of_residence'],
                ]);
            }

            // Optionally, send the password to the user via email
            Mail::to($user->email)->send(new SendUserPassword($user, $password));

            return response()->json([
                'message' => 'Driver created successfully',
                'user' => $user,
                'driver' => $driver,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function storeDriverInfo(Request $request)
    {

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'street' => 'required|string|max:255',
            'state_id' => 'required|numeric',
            'lga' => 'required|string|max:255',
            'nin_number' => 'nullable|numeric',
            'license_number' => 'nullable|numeric',
            'have_motor' => 'required|in:Yes,No',
            'guarantors.*.full_name' => 'nullable|string|max:255',
            'guarantors.*.email' => 'nullable|email',
            'guarantors.*.phone_number' => 'nullable|string|max:15',
            'guarantors.*.street' => 'nullable|string|max:255',
            'guarantors.*.state' => 'nullable|numeric',
            'guarantors.*.lga' => 'nullable|string|max:255',
            // 'guarantors.*.state_of_residence' => 'nullable|numeric',
            // 'guarantors.*.city_of_residence' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Generate a random password
            $password = Str::random(10);

            // Create the user
            $user = User::create([
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'password' => Hash::make($password),
                'user_created_by' => auth()->user()->id,
                'role_id' => 8,
                'role' => 'super_admin',
                'referral_code' => generateReferralCode(),
                'user_type' => 'driver',
                'ref_by' => auth()->user()->id,
                'status' => 'Pending',
            ]);

            // Create the driver details
            $driver = Driver::create([
                'uuid' => (string) Str::uuid(),
                'user_id' => $user->id,
                'state_id' => $request->input('state_id'),
                'have_motor' => $request->input('have_motor'),
                'street' => $request->input('street'),
                'lga' => $request->input('lga'),
                'nin_number' => $request->input('nin_number'),
                'license_number' => $request->input('license_number'),
                'status' => 'Pending',
            ]);

            $driver->proof_of_license = $this->uploadFile('driver/driver_images', $request->file('proof_of_license'));
            $driver->profile_picture = $this->uploadFile('driver/driver_images', $request->file('profile_picture'));
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

            // Optionally, send the password to the user via email
            Mail::to($user->email)->send(new SendUserPassword($user, $password));

            return response()->json([
                'message' => 'Driver created successfully',

                // 'user' => $user,
                'driver' => new DriverResource($driver),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // fro driver manager to create his person vehicle
    public function storeTruck(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [

            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'street' => 'required|string|max:255',
            'state_id' => 'required|numeric',
            'lga' => 'required|string|max:255',

            'truck_name' => 'required|string|max:255',
            'truck_type' => 'required|string|max:255',
            'truck_location' => 'required|string|max:255',
            'truck_make' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255',
            'cac_number' => 'required|string|max:255',
            'truck_description' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',


        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Generate a random password
            $password = Str::random(10);

            // Create the user
            $user = User::create([
                'full_name' => $request->input('business_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'password' => Hash::make($password),
                'user_created_by' => auth()->user()->id,
                'role_id' => 11,
                'role' => 'super_admin',
                'referral_code' => generateReferralCode(),
                'user_type' => 'truck',
                'ref_by' => auth()->user()->id,
                'status' => 'Pending',
            ]);

            // Create the truck details
            $truck = Truck::updateOrCreate(

                [
                    'uuid' => (string) Str::uuid(),
                    'user_id' => $user->id,
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

            $truck->profile_picture = $this->uploadFile('truck/truck_images', $request->file('profile_picture'));
            $truck->save();

            if ($request->input('documents')) {
                foreach ($request->input('documents') as $key => $fileData) {
                    $file = $this->uploadFileWithDetails('load_documents', $request->file("documents.$key.file"));
                    $path = $file['path'];
                    $name = $fileData['document_type'];

                    // Create a record in the load_documents table
                    $document = new LoadDocument([
                        'name' => $name,
                        'path' => $path,
                    ]);

                    // Associate the document with the LoadBulk
                    $truck->loadDocuments()->save($document);
                }
            }

            // Optionally, send the password to the user via email
            Mail::to($user->email)->send(new SendUserPassword($user, $password));

            return response()->json([
                'message' => 'Vehicle created successfully',
                'user' => $user,
                'vehicle' => $truck,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    //list all drivers
    public function my_drivers(Request $request)
    {

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::whereHas('user', function ($userQuery) use ($key) {
            $userQuery->where('full_name', 'like', "%{$key}%")
                ->where('user_created_by', auth()->id());
        })
            //->where("have_motor", "No")
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($drivers);
    }


    public function available_drivers(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::whereHas('user', function ($userQuery) use ($key) {
            $userQuery->where('full_name', 'like', "%{$key}%")
                ->whereNull('user_created_by');
        })
            ->where("status", "Confirmed")
            ->latest()
            ->paginate($perPage);

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

    public function singleDriverTrucks(Request $request)
    {

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $truck = Truck::where("driver_user_id", $request->id)
            ->latest()
            ->paginate($perPage);

        return TruckResource::collection($truck);
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


    public function driverWithTruck(Request $request)
    {

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::whereHas('trucks')
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($drivers);

        // $key = $request->input('search');
        // $perPage = $request->input('per_page', 10);

        // $truck = Truck::whereHas('driver')
        //     ->latest()
        //     ->paginate($perPage);

        // return TruckResource::collection($truck);
    }


    public function reAssignDriverToTruck(Request $request)
    {

        $request->validate([
            'truck_id' => 'required|exists:users,id',
            // 'driver_id' => 'required|exists:users,id',
            'from_order_no' => 'required|exists:load_boards,order_no',
            'to_order_no' => 'required|exists:load_boards,order_no',
        ]);

        $perPage = $request->input('per_page', 10);
        $fromLoadBoard = LoadBoard::where('status', '!=', 'delivered')->where('order_no', $request->from_order_no)->first();
        $fromLoadBoard->order->truck_by_id = null;

        $toLoadBoard = LoadBoard::where('status', '!=', 'delivered')->where('order_no', $request->to_order_no)->first();

        $toLoadBoard->order->truck_by_id = $request->truck_id;


        if ($fromLoadBoard->acceptable_id == $toLoadBoard->acceptable_id) {
            return $this->error([], "You cannot assign same truck to one driver!");
        }


        $fromLoadBoard->order->save();
        $toLoadBoard->order->save();

        //  $order =  Order::where('driver_id', auth()->id())->paginate($perPage);

        // return  new LoadBoardResource($loadBoard);

        return $this->success([
            new LoadBoardResource($toLoadBoard),
        ]);
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
        $query = LoadBoard::whereIn('load_type_id', [1, 2])
            ->where("acceptable_id", null)->orderBy('created_at', 'desc');
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

    public function singleBroadcast(Request $request, $id)
    {

        $query = LoadBoard::where("id", $id)->whereIn('load_type_id', [1, 2])->where("acceptable_id", null)->orderBy('created_at', 'desc');
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
    public function orderAssign(Request $request)
    {

        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_no' => 'required',
                'driver_id' => 'required',
            ]);

            $driver = Driver::find($request->driver_id);
            $order =  Order::where("order_no", $request->order_no)->where("driver_id", null)->first();

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

        $message = "" . auth()->user()->full_name . " ";
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
            return redirect()->away(env('FE_APP_URL') . "/monolog/?feedback=error")->withErrors($validator);
        }

        $driver = User::find($driverId);
        $manager = User::find($managerId);

        $driver->manager_request = (($status == "accepted") ? 0 : 1);
        $driver->user_created_by = (($status == "accepted") ? $manager->id : null);

        if ($driver->save()) {
            return redirect()->away(env('FE_APP_URL') . "/monolog/?feedback=$status");
        } else {
            // Handle the case where the save operation fails
            return redirect()->away(env('FE_APP_URL') . "/monolog/?feedback=error")->withErrors(['message' => 'Failed to update user']);
        }
    }



    public function deleteUserAndDriver(Request $request)
    {
        try {
            DB::beginTransaction();

            // Find the user
            $user = User::findOrFail(auth()->id());

            $driver = DriverManger::where('user_id', auth()->id())->first();

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
