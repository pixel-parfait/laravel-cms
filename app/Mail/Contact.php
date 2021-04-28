<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The email of the sender.
     *
     * @var string
     */
    public $email;

    /**
     * The message.
     *
     * @var string
     */
    public $message;

    /**
     * Create a new message instance.
     *
     * @param  string  $email
     * @param  string  $message
     * @return void
     */
    public function __construct(string $email, string $message)
    {
        $this->email = htmlspecialchars($email);
        $this->message = nl2br(htmlspecialchars($message));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact')
                    ->replyTo($this->email);
    }
}
