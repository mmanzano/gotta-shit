<?php

namespace GottaShit\Mailers;

use GottaShit\Entities\User;
use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;

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
     * Deliver the email confirmation.
     *
     * @param  User $user
     * @return void
     */
    public function sendPlaceAddNotification(User $user, Place $place, $subject)
    {
        $this->from = env('SES_EMAIL');
        $this->to = env('SES_EMAIL');
        $this->view = 'emails.notification.place';
        $path = route('place', ['language' => App::getLocale(), 'place' => $place->id]);
        $path_user = route('user_profile', ['language' => App::getLocale(), 'user' => $user->id]);
        $this->data = compact('path', 'place', 'user', 'path_user');
        $this->subject = $subject;

        $this->deliver();
    }

    /**
     * Deliver the email confirmation.
     *
     * @param  User $user
     * @return void
     */
    public function sendCommentAddNotification(User $author_of_comment, User $subscriber, Place $place, PlaceComment $comment, $subject)
    {
        $this->from = env('SES_EMAIL');
        $this->to = $subscriber->email;
        $this->view = 'emails.notification.comment';
        $path = route('place', ['language' => App::getLocale(), 'place' => $place->id]) . '#comment-' . $comment->id;
        $path_author_of_comment = route('user_profile', ['language' => App::getLocale(), 'user' => $author_of_comment->id]);
        $this->data = compact('path', 'place', 'subscriber', 'author_of_comment', 'path_author_of_comment');
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