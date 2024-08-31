<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
  use Queueable, SerializesModels;

  public $fullname;
  public $email;
  public $phone;
  public $body;

  /**
   * Create a new body instance.
   *
   * @param User $user
   * @param string $password
   * @return void
   */
  public function __construct($fullname,  $email,  $phone,  $body)
  {
    $this->fullname = $fullname;
    $this->email = $email;
    $this->phone = $phone;
    $this->body = $body;
  }

  /**
   * Build the body.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject('Monolog Contact message  by ' . $this->fullname)
      ->view('mail.contact_us')
      ->with([
        'fullname' => $this->fullname,
        'email' => $this->email,
        'phone' => $this->phone,
        'body' => $this->body,
      ]);
  }
}
