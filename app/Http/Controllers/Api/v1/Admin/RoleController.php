<?php

namespace App\Http\Controllers\api\v1\admin;

use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
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

   return $this->success(["total_roles"=>$total_role,"total_permissions"=>$total_permissions,"roles"=>$filteredRoles], 'all roles and count');
   }


   public function store(Request $request)
   {
       $request->validate([
           'name' => 'required|unique:roles,name|max:255',
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
       if (!$role->exists()) {
           abort(404, 'Role not found');
       }

       if ($role->has('users')) {
           return response()->json(['message' => 'Cannot delete role that has users'], 403);
       }

       $role->delete();

       return response()->json(['message' => 'Role deleted successfully']);
   }
}
