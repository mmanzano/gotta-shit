<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Mailers\AppMailer;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request, AppMailer $mailer, Client $client)
    {
        $this->validate($request, [
            'subject' => 'required',
            'body' => 'required',
            'email' => ['required', 'email'],
        ]);

        $response = $client->request(
            'POST',
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'query' => [
                    'secret' => config('services.recaptcha.server_secret'),
                    'response' => request('g-recaptcha-response'),
                ],
            ]
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        if ($jsonResponse['success'] ?? null) {
            $mailer->sendContactNotification(
                $request->email,
                $request->subject,
                $request->body
            );
        }

        return back();
    }
}
