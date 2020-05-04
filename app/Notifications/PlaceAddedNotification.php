<?php

namespace GottaShit\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PlaceAddedNotification extends Notification
{
    use Queueable;

    public $place;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($place)
    {
        $this->place = $place;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
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
        $path = $this->place->path;
        $place_name = $this->place->name;
        $username = $this->place->user->username;
        $user_path = $this->place->user->path;

        return (new MailMessage)
            ->subject(trans('gottashit.email.new_place_add'))
            ->markdown('notifications.place-added-notification', compact('path', 'place_name', 'username', 'user_path'));
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
