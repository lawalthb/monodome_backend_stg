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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;
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
                return $this->error(['error' => "couldn't login please check your details"], "Invalid credentials");
            }
        } catch (\Throwable $th) {
            return $this->error(['error' => $th->getMessage()]);
        }
    }


    public function handleProviderCallback(Request $request)
    {

        $validator = Validator::make($request->only('provider', 'access_provider_token'), [
            'provider' => ['required', 'string'],
            'access_provider_token' => ['required', 'string']
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);
        $provider = $request->provider;
        $validated = $this->validateProvider($provider);

        if (!is_null($validated))
            return $validated;

        try {
            $providerUser = Socialite::driver($provider)->userFromToken($request->access_provider_token);
            dd($providerUser);
            $user = User::updateOrCreate(
                [
                    'email' => $providerUser->getEmail(),
                    'provider_id' => $providerUser->getId()
                ],
                [
                    'first_name' => $providerUser->user['given_name'],
                    'provider_id' => $providerUser->getId(),
                    'password' => Hash::make($providerUser->user['given_name'] . '@' . $providerUser->getId),
                    'email_verified_at' => now(),
                ]
            );

            $user->assignRole('customer'); //register new user default.
            //$user->load('roles', 'permissions');
            Auth::login($user);
            $data =  [
                'token' => $user->createToken('monodomebackend')->plainTextToken,
                'user' => new UserResource($user),
            ];
            // return response()->json(['data'=>$data], 200);
            return $this->success($data, "success", 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 'something went wrong', 422);
        }
    }



    public function updateProfile(Request $request)
    {
        $user = auth()->user(); // Assuming you are using authentication
        // Validate the incoming request data
        $validatedData = $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id, // Ignore the current user's email
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
        ]);

        // Update user profile data
        $user->update([
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
           // $imagePath = $request->file('image')->store('profile_images', 'public');
           $imagePath =  $request->image ? $this->saveImage('profile', $request->image, 500, 500) : null;
            $user->update(['imageUrl' => $imagePath]);
        }

        return $this->success(['user' => new UserResource($user)], "Profile updated successfully");
        // return response()->json(['message' => 'Profile updated successfully']);
    }

    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['google', 'facebook', 'apple'])) {
            return response()->json(["message" => 'You can only login via google,facebook,apple account'], 400);
        }
    }
}
