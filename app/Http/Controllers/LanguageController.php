<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\PlaceStar;
use GottaShit\Entities\User;

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
     * @return Response
     */
    public function change($language)
    {
        App::setLocale($language);

        Session::put('language', $language);

        return redirect()->back();
    }
}
