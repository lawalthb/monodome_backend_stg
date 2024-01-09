<?php

namespace App\Http\Controllers\Api\v1\Company;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;


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

        $agents = company::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('street', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return CompanyResource::collection($agents);
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

    /**
     * Display the specified resource.
     */
    public function show(company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(company $company)
    {
        //
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
