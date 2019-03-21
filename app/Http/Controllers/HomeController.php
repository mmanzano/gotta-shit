<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return view('home', [
            'title' => trans('gottashit.title.welcome'),
            'places' => Place::paginate(1)
        ]);
    }
}
