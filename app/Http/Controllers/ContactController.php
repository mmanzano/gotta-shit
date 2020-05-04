<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Http\Requests\ContactStoreRequest;
use GottaShit\Notifications\ContactNotification;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(ContactStoreRequest $request, Client $client): RedirectResponse
    {
        if ($request->validateRecaptcha($client)) {
            $user = new User(['email' => config('mail.from.address')]);
            $user->notify(new ContactNotification(request('subject'), request('email'), request('body')));
        }

        return back();
    }
}
