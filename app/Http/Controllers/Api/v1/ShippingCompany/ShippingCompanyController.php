<?php

namespace App\Http\Controllers\Api\v1\ShippingCompany;

use App\Models\User;
use App\Models\Guarantor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Models\ShippingCompany;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SendNotification;
use App\Http\Requests\ShippingCompanyRequest;
use App\Http\Resources\ShippingCompanyResource;


class ShippingCompanyController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;




    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $agents = ShippingCompany::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('street', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return ShippingCompanyResource::collection($agents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingCompanyRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::firstOrNew(['email' => $request->input('email')]);

            if (!$user->exists) {
                // User doesn't exist, so create a new user
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->address = $request->input('address');
                $password  = Str::random(16);
                $user->phone_number = $request->input('phone_number');
                $user->password = Hash::make($password);
                //$user->user_type = 'company_transporter_super';
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

            $role = Role::find(5);
            if ($role) {
                $user->user_type = str_replace(' ', '_', $role->name);
                $user->role_id = $role->id;
                $user->role = "super_admin";
                $user->assignRole($role);
                $user->save();
            }

            $shippingComPany = new ShippingCompany([
                'user_id' => $user->id,
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'lga' => $request->input('lga'),
                'company_name' => $request->input('company_name'),
                'nin_number' => $request->input('nin_number'),
                'phone_number' => $request->input('phone_number'),
                'status' => 'Waiting',

            ]);
            $shippingComPany->profile_picture = $this->uploadFile('shipping_company/agent_images', $request->file('profile_picture'));


            $shippingComPany->save();

            $guarantor = new Guarantor([
                'full_name' =>  $request->input('guarantors_full_name'),
                'phone_number' =>  $request->input('guarantors_phone_number'),
                'street' =>  $request->input('guarantors_street'),
                'email' =>  $request->input('email'),
                'state' =>  $request->input('guarantors_state'),
                'lga' =>  $request->input('guarantors_lga'),
                'profile_picture' => $this->uploadFile('agent/guarantor_images', $request->file("guarantors_profile_picture")),

            ]);

            $guarantor->loadable()->associate($shippingComPany);
            $shippingComPany->guarantors()->save($guarantor);

            DB::commit();

            return $this->success(new ShippingCompanyResource($shippingComPany), 'ShippingCompany and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the ShippingCompany and guarantors.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingCompany $shippingCompany)
    {
        //
    }


    // adding users

    public function createUser(Request $request)
    {

        if (!Auth::user()->hasRole('Shipping Company')) {

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

        $role = $role = Role::find(5); //$request->input('role') == 1 ? 'super-admin' : 'admin';
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
        $user->user_type = str_replace(' ', '_', $role->name);
        $password  = Str::random(16);
        $user->password = Hash::make($password);
        //$user->user_type = 'company_transporter_super';
        $user->save();

        $role =  $role = Role::find(5); //$request->input('role') == 1 ? 'super-admin' : 'admin';
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
        // Check if the logged-in user has the 'Shipping Company' role
        if (!Auth::user()->hasRole('Shipping Company')) {
            return response()->json(['message' => 'You do not have permission to access this resource'], 403);
        }

        // Fetch the list of users registered under the logged-in user
        $myUsers = User::where('user_created_by', Auth::user()->id)->get();

        return response()->json(['message' => 'List of users registered under ' . Auth::user()->full_name, 'users' => UserResource::collection($myUsers)], 200);
    }


    public function changeRole(Request $request)
    {
        // Check if the logged-in user has the 'Shipping Company' role
        if (!Auth::user()->hasRole('Shipping Company')) {
            return response()->json(['message' => 'You do not have permission to access this resource'], 403);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:5,2', // 1 for super admin, 2 for admin
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
             $user->notify(new SendNotification($user, $message));

            return response()->json(['message' => 'User role updated successfully','user'=> new UserResource($user)], 200);
        }else{

            return response()->json(['message' => 'User not found!'], 404);
        }
    }
}
