<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Http\Requests\ContactRequest;
use GottaShit\Mailers\AppMailer;
use GuzzleHttp\Client;

class ContactController extends Controller
{
    public function store(ContactRequest $request, AppMailer $mailer, Client $client)
    {
        if ($request->validateRecaptcha($client)) {
            $mailer->sendContactNotification(
                request('email'),
                request('subject'),
                request('body')
            );
        }

        return back();
    }
}
