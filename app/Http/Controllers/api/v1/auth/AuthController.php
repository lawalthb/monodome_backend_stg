<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    public function register(RegisterRequest  $request)
    {

        $user = new User([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);
        $user->save();

        $roleName = str_replace('_', ' ', $request->input('user_type'));
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $user->assignRole($role);
        }

        $token = $user->createToken('monodomebackend' . $request->email)->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => new UserResource($user), 'token' => $token
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            $token = $user->createToken('monodomebackend' . $request->email)->plainTextToken;

            return response()->json([
                'message' => 'Login Successfully',
                'user' => new UserResource($user), 'token' => $token,
                'token' => $token
            ], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}
