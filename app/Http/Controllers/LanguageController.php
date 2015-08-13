<?php

namespace GottaShit\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceStar;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\User;

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
