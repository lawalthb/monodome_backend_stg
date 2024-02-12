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
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
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

class DriverController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

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
        $query = LoadBoard::whereIn('load_type_id', [1, 2])->where("acceptable_id", null)->orderBy('created_at', 'desc');

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

            DB::commit();

            return $this->success( new DriverResource($driver), 'Driver and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the driver and guarantors.');
        }
    }


    public function updateProfile(Request $request)
    {
        if(Auth::user()->hasRole('driver'))
        {

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

    }else{
        return $this->error(null, 'user is not a driver', 422);

    }

    }

    public function changeImage(Request $request){


        if(Auth::user()->hasRole('driver'))
        {

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
        }else{
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
    public function acceptOrder(Request $request){

        return DB::transaction(function () use ($request) {

        $request->validate([
            'load_board_id' => 'required',
            //'driver_id' => 'required',
        ]);

        $loadBoards = LoadBoard::where("id",$request->load_board_id)->whereNull('acceptable_id')
        ->whereNull('acceptable_type')->first();

        if($loadBoards){

            $driver = Driver::where("user_id",auth()->id())->first();

            $loadBoards->acceptable_id = $driver->id;
            $loadBoards->acceptable_type = get_class($driver) ;

            if($loadBoards->save()){
                $loadBoards->order->driver_id = $driver->id;
                $loadBoards->order->accepted = "Yes";
                $loadBoards->order->acceptable_id = $driver->user->id;
                $loadBoards->order->acceptable_type = get_class($driver->user) ;
              //  $loadBoards->order->placed_by_id = auth()->user()->id;
              $loadBoards->loadable->status = "Processing";
                $loadBoards->order->save();

                $message ="You have been accept order with number ". $loadBoards->order->order_no.
                " to delivery FROM: ".$loadBoards->order->loadable->sender_location.", TO: ".$loadBoards->order->loadable->receiver_location;
                $driver->user->notify(new SendNotification($driver->user, $message));

            }

            return new OrderResource($loadBoards->order);
        }else{

            return $this->error([
            ], "This load has already been taken!");
        }

    });

    }

    public function rejectOrder(Request $request){

        return DB::transaction(function () use ($request) {

        $request->validate([
            'load_board_id' => 'required',
            //'driver_id' => 'required',
        ]);

        $loadBoards = LoadBoard::where("id",$request->load_board_id)->where('acceptable_id',auth()->id())->first();

        if($loadBoards){

            $driver = Driver::where("user_id",auth()->id())->first();

            $loadBoards->acceptable_id = null;
            $loadBoards->acceptable_type = null;

            if($loadBoards->save()){
                $loadBoards->order->driver_id = null;
                $loadBoards->order->accepted = "No";
                $loadBoards->order->acceptable_id = null;
                $loadBoards->order->acceptable_type = null;
              //  $loadBoards->order->placed_by_id = auth()->user()->id;
              $loadBoards->loadable->status = "Pending";
                $loadBoards->order->save();

                $message ="You have rejected this load with ". $loadBoards->order->order_no.
                " to delivery FROM: ".$loadBoards->order->loadable->sender_location.", TO: ".$loadBoards->order->loadable->receiver_location;
                $driver->user->notify(new SendNotification($driver->user, $message));

            }

            return new OrderResource($loadBoards->order);
        }else{

            return $this->error([
            ], "This load doesn't belong to this driver");
        }

    });

    }
    public function order(Request $request)
    {

        $perPage = $request->input('per_page', 10);
         $driver = Driver::where("user_id",auth()->id())->first();

         $order =  Order::where('acceptable_id', $driver->id)
        ->where('acceptable_type', get_class($driver))
        ->paginate($perPage);

        return  OrderResource::collection($order);
    }

    public function acceptLoad(Request  $request){


    }

    public function upload_photo(Request  $request){


    }



}
