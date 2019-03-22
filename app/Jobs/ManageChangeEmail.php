<?php

namespace GottaShit\Jobs;

use GottaShit\Entities\User;
use GottaShit\Mailers\AppMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

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
     * @param AppMailer $appMailer
     * @return void
     */
    public function handle(AppMailer $appMailer)
    {
        $token = str_random(30);

        $this->user
            ->update([
                'email' => request('email'),
                'token' => $token,
                'modified' => true,
            ]);

        $appMailer->sendEmailConfirmationTo($this->user, trans('gottashit.email.confirm_email_new_subject'));
    }
}
