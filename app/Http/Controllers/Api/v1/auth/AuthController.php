<?php

namespace App\Http\Controllers\Api\v1\auth;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Notifications\SendNotification;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;
use App\Services\WalletService;


class AuthController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;
    public function register(RegisterRequest  $request)
    {
        $ip = '49.35.41.195';
        //https://beyondco.de/blog/a-guide-to-soft-delete-models-in-laravel
        try {

            $ref_by = null;

            if ($request->has('ref_by')) {
                $ref_by = User::where("referral_code", $request->ref_by)->first();
            }
            $user = new User([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'ref_by' => $ref_by ? $ref_by->id : null,
                'referral_code' => $request->referral_code ?? generateReferralCode(),
                'location' => Location::get($request->ip()),
                'user_agent' => $request->header('User-Agent'),
            ]);


            $role = Role::find($request->role_id);
            if ($role) {
                $user->user_type = Str::slug($role->name, "_");// str_replace(' ', '_', $role->name);;
                $user->role_id = $role->id;
                $user->role = $role->name;
                $user->assignRole($role);
            }

          //  if($role->id==3){
                $user->status = "Confirmed";
           // }

            $user->save();

            // add to Bonus wallet
            $data = [
                "amount" => 5,
                "payment_type" => 'wallet',
                "type" => 'credit',
                "fee" => 0,
                "description" => 'Bonus point for referring'. $user->full_name
            ];

            // check if ref_by exist and add the money to Bonus
            if($ref_by !== null){

                WalletService::createWalletAndHistory($ref_by, $data);
            }

            $message ="Thank you for Registering with ".config('app.name');
             $user->notify(new SendNotification($user, $message));
             //Mail::to($event->user->email)->send(new NewUserMail($user));

            $token = $user->createToken("monodomebackend". $request->email)->plainTextToken;

            return $this->success(
                [
                    "user" => new UserResource($user),
                    "token" => $token
                ],
                "User registered successfully"
            );
        } catch (\Throwable $th) {
            return $this->error(['error' => $th->getMessage()]);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        $user = User::where("email",$request->email)->first();

        if(!$user){

            return $this->error(['error' => "Email address not found!"],'Not found');
        }

        if($user->status == "Banned"){

            $message ="Your ".config('app.name'). " account has been Banned!. please contact ".config('app.name'). " admin for clarification ";
            $user->notify(new SendNotification($user, $message));

            return $this->error(['error' => "Your account has been Banned, and please contact admin for clarification"],'Account Banned');
        }

        if($user->status != "Confirmed"){

            return $this->error(['error' => "Your account is yet to verify!"],'Account is not activated');
        }


        try {

            if (auth()->attempt($credentials)) {
                $user = auth()->user();
                if (app()->environment('production')) {
                    $user->location = Location::get();
                }
                $user->user_agent = $request->header('User-Agent');
                $user->save();

                if(!$user->wallet){
                    $wallet = new Wallet;
                    $wallet->amount = 0;
                    $wallet->status = 'active';
                    $wallet->user_id = $user->id;
                    $wallet->save();
                }

                $token = $user->createToken('monodomebackend' . $request->email)->plainTextToken;


             $message ="There was a successful login to your ".config('app.name'). " account. Please see below login details: ";
             $user->notify(new SendNotification($user, $message));

                return $this->success(
                    [
                        "user" => new UserResource($user),
                        "token" => $token
                    ],
                    "Login Successfully"
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


        $message ="Your Profile details was updated successfully";
        $user->notify(new SendNotification($user, $message));

        return $this->success(['user' => new UserResource($user)], "Profile updated successfully");
        // return response()->json(['message' => 'Profile updated successfully']);
    }

    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['google', 'facebook', 'apple'])) {
            return response()->json(["message" => 'You can only login via google,facebook,apple account'], 400);
        }
    }

    public function me(){

        $user = User::find(auth()->id());
        return $this->success(['user' => new UserResource($user)], "Successfully");
    }

        /**
     * logout
     *
     * @param  mixed $request
     * @return void
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        //Auth::user()->currentAccessToken()->delete();

        return $this->success('', 'Logged out Successfully', 200);
    }


       /**
     * isLogin
     * check if users is login
     * @param  mixed $request
     * @return
     */
    public function isLogin(Request $request) : JsonResponse  {

        if(Auth::check()){

            return $this->success(true,true);

        }else{
            return $this->error(false, 'Session expired', 422);
        }
    }


    public function bePremium(Request $request){
        if(Auth::check()){

            $user = auth()->user();


            if($user->isPremium) return $this->success([ 'user' => new UserResource($user),],"This user is already a premium Customer!");

            $wallet = Wallet::where("user_id", $user->id)->first();

            if($wallet->amount > 500){
                $wallet->amount -= 500;

                $user->isPremium = true;
                $user->save();
                $wallet->save();

                return $this->success([
                    'user' => new UserResource($user),

                ],"Subscription is successful");

            }else{

                return $this->error(false, 'Not enough money in the wallet', 422);
            }


        }else{
            return $this->error(false, 'Session expired', 422);
        }

    }

    //get the person that refer someone
    public function getUpLineUser($code)
    {
        $validator = Validator::make(['referral_code' => $code], [
            'referral_code' => 'required|string|exists:users,referral_code'
        ]);

        if ($validator->fails()) {
            return $this->error(false, 'Invalid referral code!', 422);
        }

        $user = User::where("referral_code", $code)->first();

        return $this->success([
            'user' => new UserResource($user),
        ], "Your Up line is successful");
    }

}
