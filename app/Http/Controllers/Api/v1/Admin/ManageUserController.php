<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\SendLoginNotificationJob;
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

        $users = User::where('role_id',  2)->latest()->paginate($perPage);
//dd($users);
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
            'phone_number' => 'required|string|unique:users,phone_number',
            'password' => 'required|string',
            'permission_ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        //$password = Str::random(10);
        $user = new User([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'ref_by' => auth()->user()->id,
            'referral_code' => generateReferralCode(),
            'role_id' => 2,
            'user_agent' => $request->header('User-Agent'),
            // 'location' => Location::get($request->ip()),
        ]);

        // $role = Role::find(2);
        // if ($role) {
        //     $user->user_type = Str::slug($role->name, "_"); // str_replace(' ', '_', $role->name);;
        //     $user->role_id = $role->id;
        //     $user->role = $role->name;
        //     $user->assignRole($role);

        //     $permissions = Permission::whereIn('id', $request->permission_ids)->get();

        //     $role->syncPermissions($permissions);
        // }

        $permissions = Permission::whereIn('id', $request->permission_ids)->get();
        $user->syncPermissions($permissions);
        $user->save();

        $message = "You are now an admin at " . config('app.name') . " Thank you for Registering with " . config('app.name');
        // $user->notify(new SendNotification($user, $message));
        dispatch(new SendLoginNotificationJob($user, $message));


        $data = [
            "full_name" => $request->input('full_name'),
            "password" => $request->password,
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
    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|unique:users,phone_number,' . $user->id,
            'password' => 'nullable|string',
            'permission_ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        // Update user details
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;

        // Update password if provided
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sync permissions
        $permissions = Permission::whereIn('id', $request->permission_ids)->get();
        $user->syncPermissions($permissions);

        // Notify the user about the update
        $message = "Your profile at " . config('app.name') . " has been updated.";
        // $user->notify(new SendNotification($user, $message));
        dispatch(new SendLoginNotificationJob($user, $message));

        $data = [
            "full_name" => $request->input('full_name'),
            "password" => $request->password,
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
            "Admin profile updated successfully"
        );
    }



    public function pending(Request $request)
    {

        $perPage = $request->input('per_page', 10);

        $users = User::query();


        $users = $users->whereIn('status', ['Pending', 'Rejected'])->latest()->paginate($perPage);

        return UserResource::collection($users);
    }

    public function status(Request $request, User $user)
    {
        $this->validate($request, [
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

        $this->validate($request, [
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


    public function getUsersWithReferrers()
    {
        // Retrieve users with their number of referrers
        $users = User::whereNotNull('ref_by')
            ->withCount('referrers')
            ->get();

        return response()->json($users);
    }


    /**
     * Get the total number of users referred by a specific user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalUsersByReferrer($userId, Request $request)
    {
        // Fetch users referred by the given user
        $users = User::where('ref_by', $userId)->paginate(10);

        // Optionally, you can customize the pagination size via the query string
        // $perPage = $request->query('per_page', 10);
        // $users = User::where('ref_by', $userId)->paginate($perPage);

        return response()->json([
            'total_user' => $users->total(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'users' => $users->items(),
        ]);
    }

    /**
     * Get the top referrer based on the number of users referred.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopReferrer()
    {
        $topReferrer = User::select('ref_by', DB::raw('count(*) as total'))
            ->groupBy('ref_by')
            ->orderByDesc('total')
            ->first();

        if ($topReferrer && $topReferrer->ref_by) {
            $topReferrerUser = User::find($topReferrer->ref_by);
        } else {
            $topReferrerUser = null;
        }

        return response()->json([
            'top_referrer' => new UserResource($topReferrerUser),
            'total_referrals' => $topReferrer ? $topReferrer->total : 0,
        ]);
    }

    public function getUplineByUserId($userId)
    {
        // Fetch the user by ID
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        // Fetch the upline (referrer) based on the ref_by field
        $upline = User::find($user->ref_by);

        if (!$upline) {
            return response()->json([
                'message' => 'Upline not found.'
            ], 404);
        }

        return response()->json($upline);
    }
}
