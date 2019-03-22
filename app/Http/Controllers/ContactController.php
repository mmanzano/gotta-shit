<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Http\Requests\ContactStoreRequest;
use GottaShit\Mailers\AppMailer;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(ContactStoreRequest $request, AppMailer $appMailer, Client $client): RedirectResponse
    {
        if ($request->validateRecaptcha($client)) {
            $appMailer->sendContactNotification(
                request('email'),
                request('subject'),
                request('body')
            );
        }

        return back();
    }
}
