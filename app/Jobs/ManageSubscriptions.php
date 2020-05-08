<?php

namespace GottaShit\Jobs;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Notifications\CommentAddedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ManageSubscriptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Place */
    public $place;

    /** @var PlaceComment */
    public $comment;

    /**
     * Create a new job instance.
     *
     * @param Place $place
     * @param PlaceComment $comment
     */
    public function __construct(Place $place, PlaceComment $comment)
    {
        $this->place = $place;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Auth::user()->updateOrCreateSubscription($this->place);

        $this->place
            ->subscriptions()
            ->where('user_id', '!=', Auth::id())
            ->whereNull('comment_id')
            ->get()
            ->each(function ($subscription) {
                $subscription->user->notify(
                    new CommentAddedNotification($this->comment, $subscription)
                );
            });
    }
}
