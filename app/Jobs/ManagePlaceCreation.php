<?php

namespace GottaShit\Jobs;

use GottaShit\Entities\Place;
use GottaShit\Mailers\AppMailer;
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
        $appMailer->sendPlaceAddNotification(
            Auth::user(),
            $this->place,
            trans('gottashit.email.new_place_add')
        );
    }
}
