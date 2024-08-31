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
      'fullname' => 'required|string',
      'phone' => 'required|string',
      'message' => 'required|string',
      'email' => 'required|string',
    ]);


    Mail::to('lawalthb@gmail.com')->send(new ContactUsMail($request->fullname, $request->email, $request->phone, $request->message));
  }
}
