<?php

namespace App\Http\Controllers\Api\v1\ContactUs;


use App\Models\Contact;
use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{

    public function send(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required',
            'body' => 'required',
            'email' => 'required|email',
        ]);

        // Save the contact submission to the database
        $contactSubmission = Contact::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'body' => $request->body,
        ]);

        try {
            // Send the email
            Mail::to(env('SUPPORT_EMAIL'))->send(new ContactUsMail(
                $contactSubmission->fullname,
                $contactSubmission->email,
                $contactSubmission->phone,
                $contactSubmission->body
            ));

            return response()->json([
                'message' => 'Message sent successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
