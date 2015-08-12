<?php

namespace GottaShit\Mailers;

use GottaShit\Entities\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\App;

class AppMailer
{

    /**
     * The Laravel Mailer instance.
     *
     * @var Mailer
     */
    protected $mailer;

    /**
     * The sender of the email.
     *
     * @var string
     */
    protected $from;

    /**
     * The recipient of the email.
     *
     * @var string
     */
    protected $to;

    protected $subject;
    /**
     * The view for the email.
     *
     * @var string
     */
    protected $view;

    /**
     * The data associated with the view for the email.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new app mailer instance.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Deliver the email confirmation.
     *
     * @param  User $user
     * @return void
     */
    public function sendEmailConfirmationTo(User $user, $subject)
    {
        $this->from = env('SES_EMAIL');
        $this->to = $user->email;
        $this->view = 'emails.confirm';
        $path = route('user_register_confirm', ['language' => App::getLocale(), 'token' => $user->token]);
        $this->data = compact('user', 'path');
        $this->subject = $subject;

        $this->deliver();
    }

    /**
     * Deliver the email.
     *
     * @return void
     */
    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, 'GottaShit')
              ->to($this->to)->subject($this->subject);
        });
    }
}