<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactVendor extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;
    public $user;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vendor, $user, $message)
    {
        $this->vendor = $vendor;
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Message')->view('emails.contact-vendor-email');
    }
}
