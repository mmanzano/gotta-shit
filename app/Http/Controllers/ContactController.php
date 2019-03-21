<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Http\Requests\ContactStoreRequest;
use GottaShit\Mailers\AppMailer;
use GuzzleHttp\Client;

class ContactController extends Controller
{
    public function store(ContactStoreRequest $request, AppMailer $mailer, Client $client)
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
