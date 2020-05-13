<?php

namespace App\Http\Controllers;

use App\Entities\Place;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'title' => trans('gottashit.title.welcome'),
            'places' => Place::paginate(1)
        ]);
    }
}
