<?php

namespace GottaShit\Mailers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\Subscription;
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

    public function sendEmailConfirmationTo(User $user, string $subject)
    {
        $this->from = env('SES_EMAIL');
        $this->to = $user->email;
        $this->view = 'emails.confirm';
        $path = route('user_register_confirm',
            ['language' => App::getLocale(), 'token' => $user->token]);
        $this->data = compact('user', 'path');
        $this->subject = $subject;

        $this->deliver();
    }

    public function sendPlaceAddNotification(User $user, Place $place, string $subject)
    {
        $this->from = env('SES_EMAIL');
        $this->to = env('SES_EMAIL');
        $this->view = 'emails.notification.place';
        $path = route('place.show',
            ['language' => App::getLocale(), 'place' => $place->id]);
        $path_user = route('user.show',
            ['language' => App::getLocale(), 'user' => $user->id]);
        $this->data = compact('path', 'place', 'user', 'path_user');
        $this->subject = $subject;

        $this->deliver();
    }

    public function sendCommentAddNotification(
        User $author_of_comment,
        User $subscriber,
        Place $place,
        PlaceComment $comment,
        Subscription $subscription,
        string $subject
    ) {
        if (!$subscriber->modified) {
            $this->from = env('SES_EMAIL');
            $this->to = $subscriber->email;
            $this->view = 'emails.notification.comment';
            $path = route('place.show', [
                    'language' => App::getLocale(),
                    'place' => $place->id
                ]) . '#comment-' . $comment->id;
            $path_author_of_comment = route('user.show', [
                'language' => App::getLocale(),
                'user' => $author_of_comment->id
            ]);
            $this->data = compact('path', 'place', 'subscriber',
                'author_of_comment', 'path_author_of_comment');
            $this->subject = $subject;

            $this->deliver();

            $subscription->comment_id = $comment->id;
            $subscription->save();
        }
    }

    public function sendContactNotification(string $email, string $subject, string $body)
    {
        $this->from = env('SES_EMAIL');
        $this->to = env('SES_EMAIL');
        $this->view = 'emails.notification.contact';
        $this->data = compact('email', 'body');
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
        $this->mailer
            ->send($this->view, $this->data, function ($message) {
                $message->from($this->from, 'GottaShit')
                    ->to($this->to)->subject($this->subject);
            });
    }
}
