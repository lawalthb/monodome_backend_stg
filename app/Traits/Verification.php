<?php

namespace App\Traits;

use App\Mail\SendCodeMail;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;

trait Verification
{
    protected function sendVerificationCode($email)
    {
        // Delete all old codes for the user's email
        PasswordReset::where('email', $email)->delete();

        // Generate a random code
        $code = getOTPNumber(6); // You need to define the `getNumber` function

        // Create a new password reset record
        $passwordReset = PasswordReset::create([
            'email' => $email,
            'code' => $code,
        ]);

        // Send an email with the verification code
        if ($passwordReset) {
            Mail::to($email)->send(new SendCodeMail($passwordReset));

            return true;
        } else {
            return false;
        }
    }

    protected function verifyOTPCode($email, $code)
    {
        try {
            // Find the password reset record
            $passwordReset = PasswordReset::where('email', $email)
                ->where('code', trim($code))
                ->first();

            if (!$passwordReset) {
                return false; // Code not found or doesn't match
            }

            // Check if the code has expired (1 hour)
            if ($passwordReset->created_at->addHour()->isPast()) {
                $passwordReset->delete(); // Delete expired code
                return false;
            }

            return true; 
        } catch (\Throwable $th) {
            return false;
        }
    }
}
