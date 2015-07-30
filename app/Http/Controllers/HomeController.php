<?php

namespace GottaToShit\Http\Controllers;

use GottaToShit\Entities\Place;

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
        $places = Place::paginate(8);

        return view('home', compact('places'));
    }
}
