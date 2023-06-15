<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCredentialMail extends Mailable
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
    public function envelope()
    {
        $subject = 'Hiring Manager Credential Mail';
        if ($this->data['role'] == 'admin') {
            $subject = 'Admin Credential Mail';
        } elseif ($this->data['role'] == 'company-admin') {
            $subject = 'Company Admin Credential Mail';
        } elseif ($this->data['role'] == 'investigator') {
            $subject = 'Investigator Credential Mail';
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $roleText = 'hiring manager';
        if ($this->data['role'] == 'admin') {
            $roleText = 'admin';
        } elseif ($this->data['role'] == 'company-admin') {
            $roleText = 'company admin';
        } elseif ($this->data['role'] == 'investigator') {
            $roleText = 'investigator';
        }
        return new Content(
            markdown: 'emails.user_credential',
            with: ['data' => $this->data, 'roleText' => $roleText]
        );
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
