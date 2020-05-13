<?php

namespace App\Jobs;

use App\Entities\Place;
use App\Entities\User;
use App\Notifications\PlaceAddedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
     * @return void
     */
    public function handle()
    {
        $user = new User(['email' => config('mail.from.address')]);

        $user->notify(new PlaceAddedNotification($this->place));
    }
}
