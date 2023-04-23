<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use  App\Services\EmailSender;

class EventMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $options;

    /**
     * EventMail constructor.
     * @param string $subject
     * @param string $template
     * @param array $options
     */
    public function __construct(string $subject, string $template, array $options = [])
    {
        $this->subject = $subject;
        $this->template = $template;
        $this->options = $options;
        $this->cc(EmailSender::getCc());
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->template)->with($this->options);
    }

    public function send(MailerContract $mailer)
    {
        parent::send($mailer);
    }
}
