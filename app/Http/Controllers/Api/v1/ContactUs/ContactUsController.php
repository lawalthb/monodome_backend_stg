<?php

namespace App\Http\Controllers\Api\v1\ContactUs;


use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class ContactUsController extends Controller
{

  public function send(Request $request)
  {
    $request->validate([
      'fullname' => 'required',
      'phone' => 'required',
      'body' => 'required',
      'email' => 'required',
    ]);

    $fullname = $request->fullname;

    $email = $request->email;

    $phone = $request->phone;

    $body = $request->body;


    try {
      Mail::to('lawalthb@gmail.com')->send(new ContactUsMail($fullname, $email, $phone, $body));
      return response()->json([
        'message' => 'Message sent successfully',

      ], 201);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}
