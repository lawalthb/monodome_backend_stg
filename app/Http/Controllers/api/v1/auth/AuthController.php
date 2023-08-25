<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    public function register(RegisterRequest  $request){

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

        return response()->json(['message' => 'User registered successfully'], 201);


    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('monodomebackend' . $request->email)->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

}
