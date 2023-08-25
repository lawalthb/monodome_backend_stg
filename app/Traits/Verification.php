<?php

namespace App\Traits\Users;

use App\Mail\SendCodeMail;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;


trait Verification
{

        /**
     * sendVerificationCode
     *
     * @param  mixed $email
     * @return void
     */
    protected function sendVerificationCode($email)
    {

        // Delete all old code that user send before.
        PasswordRest::where('email', $email)->delete();

        // Generate random code
        $code = getNumber(4);

        // Create a new code
        $codeData =  PasswordReset::create(['email' => $email, 'code' => $code]);

        $codeData['first_name'] = $codeData->user->first_name;


        // Send email to user
        if ($codeData) {
            Mail::to($email)->send(new SendCodeMail($codeData));

            return true;
        } else {

            return false;
        }

        // dispatch(new sendEmailJob($data));

    }

    /**
     * verifyCode
     *
     * @param  mixed $code
     * @return void
     */
    protected function verifyOTPCode($code)
    {
        try {

        // find the code
        $passwordReset = PasswordReset::firstWhere('code', trim($code));

        // check if it does not expired: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();

            return false;
        }
        return true;

           //code...
        } catch (\Throwable $th) {
           return false;
        }
    }
}
