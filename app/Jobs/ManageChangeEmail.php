<?php

namespace App\Jobs;

use App\Entities\User;
use App\Notifications\UserConfirmationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ManageChangeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var User */
    public $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = str_random(30);

        $this->user
            ->update([
                'email' => request('email'),
                'token' => $token,
                'modified' => true,
            ]);

        $this->user->notify(new UserConfirmationNotification(trans('gottashit.email.confirm_email_new_subject')));
    }
}
