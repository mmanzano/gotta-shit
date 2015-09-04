<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\PlaceStar;
use GottaShit\Entities\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Session;

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
        $this->setLanguage();

        $places = Place::paginate(1);

        $title = trans('gottashit.title.welcome');

        return view('home', compact('title', 'places'));
    }

    /**
     * Show the application dashboard to the user.
     *
     * @param $language
     * @return \GottaShit\Http\Controllers\Response
     */
    public function index_locale($language)
    {
        $this->setLanguage($language);

        $places = Place::paginate(1);

        $title = trans('gottashit.title.welcome');

        return view('home', compact('title', 'places'));
    }
}
