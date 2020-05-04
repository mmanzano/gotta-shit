<?php

namespace GottaShit\Jobs;

use GottaShit\Entities\Place;
use GottaShit\Entities\User;
use GottaShit\Mailers\AppMailer;
use GottaShit\Notifications\PlaceAddedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;

class ManagePlaceCreation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $place;

    /**
     * Create a new job instance.
     *
     * @param Place $place
     */
    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    /**
     * Execute the job.
     *
     * @param AppMailer $appMailer
     * @return void
     */
    public function handle(AppMailer $appMailer)
    {
        $user = new User(['email' => config('mail.from.address')]);

        $user->notify(new PlaceAddedNotification($this->place));
    }
}
