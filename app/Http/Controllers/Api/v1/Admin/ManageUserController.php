<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SendNotification;
use App\Http\Resources\UserRoleResource;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class ManageUserController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $key = request()->input('search');
        $perPage = request()->input('per_page', 10);

        $users = User::role('admin')->orWhere('full_name', 'like', "%{$key}%")->orWhere('email', 'like', "%{$key}%")->latest()->paginate($perPage);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email,', // Ignore the current user's email
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'password' => 'nullable|string',
            'permission_ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $password = Str::random(10);
        $user = new User([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($password),
            'role_id' => 2,
            'user_agent' => $request->header('User-Agent'),
            // 'location' => Location::get($request->ip()),
        ]);

        $role = Role::find(2);
        if ($role) {
            $user->user_type = Str::slug($role->name, "_"); // str_replace(' ', '_', $role->name);;
            $user->role_id = $role->id;
            $user->role = $role->name;
            $user->assignRole($role);

            $permissions = Permission::whereIn('id', $request->permission_ids)->get();

            $role->syncPermissions($permissions);
        }
        $user->save();

        $message = "You are now an admin at " . config('app.name') . " Thank you for Registering with " . config('app.name');
        $user->notify(new SendNotification($user, $message));


        $data = [
            "full_name" => $request->input('full_name'),
            "password" => $password,
            "message" => "",
        ];

        //only send password to drivers that doesnt have motor
        if ($request->input('full_name') == "Yes") {
            Mail::to($user->email)->send(
                new SendPasswordMail($data)
            );
        }

        return $this->success(
            [
                "user" => new UserResource($user),
            ],
            "Admin registered successfully"
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function status(Request $request, User $user)
    {
        $this->validate($request,[
            'status' => 'required|string|in:Pending,Confirmed,Confirmed,Rejected,Banned',

        ]);
        if ($user) {

        $user->status = $request->status;
        $user->save();

        return $this->success(
            [
                "user" => new UserResource($user),
            ],
            "Status updated successfully"
        );

    } else {

        return response()->json(['message' => 'User not found!'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the driver by ID
            $user = User::find($id);

            if (!$user) {
                return $this->error('', 'User not found', 404);
            }

            $user->delete();

            return $this->success([], 'user deleted successfully');
        } catch (\Exception $e) {
            return $this->error('', 'Unable to delete user', 500);
        }
    }


    public function user_role_auth(Request $request, User $user)
    {

        $user = Auth::user();
        if ($user) {

            return response()->json(['message' => $user->full_name . ' roles', 'roles' =>  UserRoleResource::collection($user->roles), 'permission' => $user->getAllPermissions()], 200);
        } else {

            return response()->json(['message' => 'User not found!'], 404);
        }
    }


    public function change_password(Request $request, User $user)
    {

        $this->validate($request,[
                        'password' => 'required|string|min:6|confirmed',

        ]);
        //   $user = Auth::user();
        if ($user) {

            $password = Str::random(10);
            $user->password = Hash::make($password);
            $user->save();

            return response()->json(['message' => $user->full_name . ' roles', 'roles' =>  UserRoleResource::collection($user->roles), 'permission' => $user->getAllPermissions()], 200);
        } else {

            return response()->json(['message' => 'User not found!'], 404);
        }
    }


    public function user_role(Request $request, User $user)
    {

        //   $user = Auth::user();
        if ($user) {

            return response()->json(['message' => $user->full_name . ' roles', 'roles' =>  UserRoleResource::collection($user->roles), 'permission' => $user->getAllPermissions()], 200);
        } else {

            return response()->json(['message' => 'User not found!'], 404);
        }
    }
}
