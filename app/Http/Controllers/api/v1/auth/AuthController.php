<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Spatie\Permission\Models\Role;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    use FileUploadTrait,ApiStatusTrait;
    public function register(RegisterRequest  $request)
    {

        try {

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

            return $this->success(
                [
                    'user' => new UserResource($user),
                    'token' => $token
                ],
                'User registered successfully'
            );
        } catch (\Throwable $th) {
            return $this->error(['error' => $th->getMessage()]);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {


        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            $token = $user->createToken('monodomebackend' . $request->email)->plainTextToken;


            return $this->success(
                [
                    'user' => new UserResource($user),
                    'token' => $token
                ],
                'Login Successfully'
            );

        } else {
            return $this->error(['error' => "couldn't login please check your details"],"Invalid credentials");
        }

    } catch (\Throwable $th) {
        return $this->error(['error' => $th->getMessage()]);    }
    }
}
