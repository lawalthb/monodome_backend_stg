<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Wallet;
use App\Mail\NewUserMail;
use App\Traits\Verification;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Spatie\Permission\Models\Role;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use App\Notifications\SendNotification;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class AdminAuthController extends Controller
{
    use FileUploadTrait, ApiStatusTrait,Verification;
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email', // Ignore the current user's email
            'password' => 'required|string',
            'otp' => 'required|numeric',
        ]);



        if (!$this->verifyOTPCode($request->email, $request->otp) ||  $request->otp===000000) {
            return $this->error('', 'Invalid OTP', 422);
        }

        $credentials = $request->only(['email', 'password']);

        try {

            if (auth()->attempt($credentials)) {
                $user = auth()->user();
                $user->location =  Location::get();
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
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        //Auth::user()->currentAccessToken()->delete();

        return $this->success('', 'Logged out Successfully', 200);
    }


    public function reset_password_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
            'otp' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'], // Make sure to add 'confirmed'
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        // Verify OTP (you need to implement this part)
        if (!$this->verifyOTPCode($request->email, $request->otp)) {
            return $this->error('', 'Invalid OTP', 422);
        }

        // Update password
        $user = User::where("email", $request->email)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return $this->success('', 'Password reset successful');
    }

    public function send_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        if (!$this->email_exist($request)) {
            return $this->error('', "Email address couldn't be found", 422);
        }

        if ($this->sendVerificationCode($request->email)) {
            return $this->success('', 'Code sent to your email or phone number');
        } else {
            return $this->error('', 'Code sending error, try again', 422);
        }
    }

    public function email_exist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $user = User::where("email", $request->email)->first();

        return $user ? true : false;
    }


    public function check_if_email_exist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $user = User::where("email", $request->email)->first();

        if( $user){
            return $this->success('', 'Email Exist');
        }else{
            return $this->error('', "Email address doesn't Exist", 422);
        }
    }

    public function otp_verification_submit(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
            'otp' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        // Verify OTP (you need to implement this part)
        if (!$this->verifyOTPCode($request->email, $request->otp)) {
            return $this->error('', 'Invalid OTP', 422);
        }

        return $this->success('', 'OTP Code is valid!');
    }
}
