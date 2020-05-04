<?php

namespace GottaShit\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentAddedNotification extends Notification
{
    use Queueable;

    public $comment;
    public $subscription;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $subscription)
    {
        $this->comment = $comment;
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->modified) {
            return [];
        }

        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->view = 'emails.notification.comment';
        $path = $this->comment->path;
        $place_name = $this->comment->place->name;

        $this->subscription->comment_id = $this->comment->id;
        $this->subscription->save();

        $subject = trans(
            'gottashit.email.new_comment_add',
            ['place' => $this->comment->place->name],
            $notifiable->language
        );

        return (new MailMessage)
            ->subject($subject)
            ->markdown('notifications.comment-added-notification', compact('path', 'place_name'));
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
            //
        ];
    }
}
