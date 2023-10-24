<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserRoleResource;

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
        $roles = Role::all();
        // Filter roles to exclude "admin" and "Super Admin"
    $filteredRoles = $roles->filter(function ($role) {
        $roleName = strtolower($role->name);
        return $roleName !== 'admin' && $roleName !== 'super admin';
    });

        return response()->json(['roles' => $filteredRoles]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        $role = Role::create(['name' => $request->name]);

        return response()->json(['role' => $role, 'message' => 'Role created successfully']);
    }


     /**
     * Display the specified role.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        return response()->json(['role' => $role]);
    }


    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|max:255',
        ]);

        $role->update(['name' => $request->name]);

        return response()->json(['role' => $role, 'message' => 'Role updated successfully']);
    }


    /**
     * Remove the specified role from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }



    public function user_role(Request $request, User $user)
    {

        $user = Auth::user();
        if ($user) {

            return response()->json(['message' => $user->full_name.' roles', 'roles' =>  UserRoleResource::collection($user->roles),'permission' =>$user->getAllPermissions() ], 200);
        } else {

            return response()->json(['message' => 'User not found!'], 404);
        }
    }


}
