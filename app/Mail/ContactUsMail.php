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
  public $message;

  /**
   * Create a new message instance.
   *
   * @param User $user
   * @param string $password
   * @return void
   */
  public function __construct(string $fullname, string $email, string $phone, string $message)
  {
    $this->fullname = $fullname;
    $this->email = $email;
    $this->phone = $phone;
    $this->message = $message;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject('Monolog Contact Message  by ' . $this->fullname)
      ->view('mail.contact_us')
      ->with([
        'fullname' => $this->fullname,
        'email' => $this->email,
        'phone' => $this->phone,
        'message' => $this->message,
      ]);
  }
}
