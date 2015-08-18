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

    public function setLanguage($language='en') {
        if(Auth::check()) {
            App::setLocale(Auth::user()->language);
        } else {
            if(Session::get('language')){
                App::setLocale(Session::get('language'));
            } else {
                App::setLocale($language);
            }
        }
    }

    public function setLanguageUser(User $user) {
        App::setLocale($user->language);
    }
}
