<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Mailers\AppMailer;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'subject' => 'required',
            'body' => 'required',
            'email' => ['required', 'email'],
        ]);

        $mailer->sendContactNotification(
            $request->email,
            $request->subject,
            $request->body
        );

        return back();
    }
}
