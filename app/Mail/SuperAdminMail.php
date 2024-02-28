<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuperAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    /* public function envelope()
    {
        return new Envelope(
            subject: 'Super Admin Mail',
        );
    } */

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
  


    public function build()
    {
        $roleText = 'Hiring Manager';
        if ($this->data['role'] == 'company-admin') {
            $roleText = 'Company Admin';
        } elseif ($this->data['role'] == 'investigator') {
            $roleText = 'Investigator';
        }

        $subject = 'New User Registration Mail';

        return $this->subject($subject)->markdown('emails.newUserEmailNotification',['data' => $this->data, 'roleText' => $roleText]);
        // return $this->view('emails.user_credential',['data' => $this->data, 'roleText' => $roleText]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
