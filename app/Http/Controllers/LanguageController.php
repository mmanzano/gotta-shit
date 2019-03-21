<?php

namespace GottaShit\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function store(string $language): RedirectResponse
    {
        App::setLocale($language);

        Session::put('language', $language);

        optional(Auth::user())->setLanguage($language);

        return redirect($this->changeRoute($language));
    }

    private function changeRoute(string $language): string
    {
        $backRoute = request()->headers->get('referer');

        return preg_replace('/\/(es|en)\/?/', "/{$language}/", $backRoute);
    }
}
