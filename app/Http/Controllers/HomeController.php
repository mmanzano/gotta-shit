<?php

namespace GottaShit\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceStar;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\User;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's principal screen.
    |
    */

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        if(Session::get('language')){
            App::setLocale(Session::get('language'));
        }

        $places = Place::paginate(1);

        return view('home', compact('places'));
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index_locale($language)
    {
        App::setLocale(Session::get('language', $language));

        $places = Place::paginate(1);

        return view('home', compact('places'));
    }
}
