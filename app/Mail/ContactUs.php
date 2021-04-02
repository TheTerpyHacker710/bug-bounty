<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactVendor extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $message;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $message, $email)
    {
        $this->name = $name;
        $this->message = $message;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Message from' + $name)->from($email)->view('emails.contact-vendor-email');
    }
}
