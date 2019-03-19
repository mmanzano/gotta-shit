<?php

namespace GottaShit\Jobs;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\Subscription;
use GottaShit\Mailers\AppMailer;
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
        $this->coment = $comment;
    }

    /**
     * Execute the job.
     *
     * @param AppMailer $appMailer
     * @return void
     */
    public function handle(AppMailer $appMailer)
    {
        $userSubscription = $this->place->auth_user_subscription;

        if ($userSubscription === null) {
            $userSubscription = Subscription::create([
                'place_id' => $this->place->id,
                'user_id' => Auth::id(),
            ]);
        }

        $userSubscription->update(['comment_id' => null]);

        $this->place->subscriptions()
            ->where('user_id', '!=', Auth::id())
            ->whereNull('comment_id')
            ->get()
            ->each(function ($subscription) use ($appMailer) {
                $appMailer->sendCommentAddNotification(
                    Auth::user(),
                    $subscription->user,
                    $this->place,
                    $this->comment,
                    $subscription,
                    trans(
                        'gottashit.email.new_comment_add',
                        [
                            'place' => $this->place->name,
                        ],
                        $subscription->user->language
                    )
                );
            });
    }
}
