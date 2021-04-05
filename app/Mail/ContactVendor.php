<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactVendor extends Mailable
{
    use Queueable, SerializesModels;

    public $validData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($validData)
    {
        $this->validData = $validData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Message from ' . $this->validData['name'])->from($this->validData['email'])->view('emails.contact-vendor-email');
    }
}
