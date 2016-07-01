<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Session;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public function setLanguage($language = null)
    {
        $locale = [
            'en' => '',
            'es' => 'es_ES.UTF-8',
        ];

        if (Auth::check()) {
            $language = Auth::user()->language;
        } else {
            if (Session::get('language')) {
                $language = Session::get('language');
            } else {
                if (is_null($language)) {
                    $language = $this->getLanguageFromBrowser();
                }
            }
        }

        App::setLocale($language);
        setlocale(LC_TIME, $locale[$language]);
    }

    public function setLanguageUser(User $user)
    {
        App::setLocale($user->language);
    }

    private function getLanguageFromBrowser()
    {
        $accept = strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        $lang = explode(",", $accept);
        $primary_language = explode('-', $lang[0]);
        $language = $primary_language[0];

        if ($language != 'en' && $language != 'es') {
            $language = 'en';
        }

        return $language;
    }
}
