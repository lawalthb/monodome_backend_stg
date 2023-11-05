<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendNotification;
use App\Http\Resources\UserRoleResource;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $roles = Role::get();
        // Filter roles to exclude "admin" and "Super Admin"
        $filteredRoles = $roles->filter(function ($role) {
            $roleName = strtolower($role->name);
            return $roleName !== 'admin' && $roleName !== 'super admin';
        });

        $total_role = Role::count();
        $total_permissions = Permission::count();

        return $this->success(["total_roles" => $total_role, "total_permissions" => $total_permissions, "roles" => $roles], 'all roles and count');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|max:255',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => "api"]);

        return $this->success(['role' => $role, 'message' => 'Role created successfully']);
        // return response()->json();
    }


    /**
     * Display the specified role.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        return $this->success(['role' => $role, 'message' => 'Single Role']);
    }


    public function update(Request $request, Role $role, User $user)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|max:255',
        ]);

        $role->update(['name' => $request->name]);

        return $this->success(['role' => $role, 'message' => 'Role updated successfully']);
    }


    /**
     * Remove the specified role from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        if (!$role->exists()) {
            abort(404, 'Role not found');
        }

        if ($role->has('users')) {

            return $this->error([], 'Cannot delete role that has users');
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }


    public function changeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'role_id' => 'required|exists:roles,id', // 1 for super admin, 2 for admin
        ]);

        // Fetch the list of users registered under the logged-in user
        $user = User::find($request->user_id);

        $role = $role = Role::find($request->input('role_id')); //$request->input('role') == 1 ? 'super-admin' : 'admin';
        if ($user) {
            // User already exists; update their role
            $user->user_type = Str::slug($role->name, "_");
            $user->save();
            $user->syncRoles([$role]);
            $message = "Your Role has been changed to " . $role->name;
            $user->notify(new SendNotification($user, $message));

            return response()->json(['message' => 'User role updated successfully', 'user' => new UserResource($user)], 200);
        } else {

            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    public function user_role(User $user)
    {

        if ($user) {

            return response()->json(['message' => $user->full_name.' roles', 'roles' =>  UserRoleResource::collection($user->roles),'permission' =>$user->getAllPermissions() ], 200);
        } else {

            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    public function givePermissionToRole(Request $request, Role $role){

        $request->validate([
            'permission_ids' => 'required|array|exists:roles,id', // 1 for super admin, 2 for admin
        ]);

       $permissions = Permission::whereIn('id',$request->permission_ids)->get();

       $role->syncPermissions($permissions);


       if(Role::with('permissions')->get()){
        return response()->json(['message' => 'Updated successfully', 'role' => Role::with('permissions')->get()], 200);
     } else {

         return response()->json(['message' => 'Unable to perform actions!'], 404);
     }

    }


    public function removePermissionToRole(Request $request, Role $role){

        $request->validate([
            'permission_id' => 'required|numeric|exists:roles,id', // 1 for super admin, 2 for admin
        ]);

       $permissions = Permission::where('id',$request->permission_ids)->first();

       $role->revokePermissionTo($permissions);

        if(Role::with('permissions')->get()){
       return response()->json(['message' => 'Updated successfully', 'role' => Role::with('permissions')->get()], 200);
    } else {

        return response()->json(['message' => 'Unable to perform operation!'], 404);
    }

    }
}
