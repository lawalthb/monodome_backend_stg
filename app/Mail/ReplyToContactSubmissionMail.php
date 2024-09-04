<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyToContactSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fullname;
    public $replyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($fullname, $replyMessage)
    {
        $this->fullname = $fullname;
        $this->replyMessage = $replyMessage;
    }


    public function build()
    {
      return $this->subject('Monolog Contact message  by ' . $this->fullname)
        ->view('mail.reply_to_contact_submission')
        ->with([
          'fullname' => $this->fullname,
          'replyMessage' => $this->replyMessage,
        ]);
    }
}
