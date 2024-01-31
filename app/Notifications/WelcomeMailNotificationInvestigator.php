<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class WelcomeMailNotificationInvestigator extends Notification
{
    use Queueable;

    public $user;
    public $pass;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $pass = 0)
    {
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
            $mailData = [
            'name' => $this->user->first_name,
            'email' => $this->user->email,
            'password' => $this->pass,
        ];

        return (new MailMessage)->markdown(
                'emails.welcome-investigator', ['mailData' => $mailData]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
