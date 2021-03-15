<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Tip extends Notification implements shouldQueue
{
    use Queueable;

    protected $tip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tip)
    {
        $this->tip = $tip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'tip_text' => $this->tip,
        ];
    }
}
