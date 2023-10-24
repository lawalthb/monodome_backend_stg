<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserRoleResource;

class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
