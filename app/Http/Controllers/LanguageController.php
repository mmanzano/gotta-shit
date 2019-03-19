<?php

namespace GottaShit\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Language Controller
    |--------------------------------------------------------------------------
    |
    | This controller changes your application language
    |
    */

    /**
     * Change the language
     *
     * @param string $language
     * @return Response
     */
    public function change(string $language)
    {
        App::setLocale($language);

        Session::put('language', $language);

        if (Auth::check()) {
            Auth::user()->setLanguage($language);
        }

        $backRoute = request()->headers->get('referer');

        $backRouteWithLanguage = preg_replace('/\/(es|en)\/?/', "/{$language}/", $backRoute);

        return redirect()->to($backRouteWithLanguage);
    }
}
