<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\PlaceStar;
use GottaShit\Entities\User;
use GottaShit\Http\Requests;
use GottaShit\Http\Controllers\Controller;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($language)
    {
        App::setLocale(Session::get('language', $language));

        $places = Place::paginate(8);

        return view('places', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($language)
    {
        App::setLocale(Session::get('language', $language));

        return view('place.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $language)
    {
        App::setLocale(Session::get('language', $language));

        $this->validate($request, [
          'name' => 'required|max:255',
          'geo_lat' => 'required|numeric|between:-90,90',
          'geo_lng' => 'required|numeric|between:-180,180',
          'stars' => 'required|numeric|between:0,5',
        ]);

        $place = new Place();

        $place->name = $request->input('name');
        $place->geo_lat = number_format($request->input('geo_lat'), 6);
        $place->geo_lng = number_format($request->input('geo_lng'), 6);
        $place->user_id = Auth::user()->id;
        
        $place->save();

        $star = new PlaceStar();

        $star->place_id = $place->id;
        $star->user_id = Auth::user()->id;
        $star->stars = $request->input('stars');

        $star->save();

        $status_message = trans('gottashit.place.created_place', ['place' =>  $place->name]);

        return redirect(route('place', ['language' => $language, 'place' => $place->id]))->with('status', $status_message);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($language, $id)
    {
        App::setLocale(Session::get('language', $language));

        $place = Place::withTrashed()->findOrFail($id);

        if($place->trashed() && ! $place->isAuthor)
        {
            return redirect(route('home', ['language'=> $language]));
        }

        Carbon::setLocale(App::getLocale());

        return view('place', compact('place'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($language, $id)
    {
        App::setLocale(Session::get('language', $language));

        $place = Place::findOrFail($id);

        return view('place.edit', compact('place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $language, $id)
    {
        App::setLocale(Session::get('language', $language));

        $this->validate($request, [
          'name' => 'required|max:255',
          'geo_lat' => 'required|numeric|between:-90,90',
          'geo_lng' => 'required|numeric|between:-180,180',
          'stars' => 'required|numeric|between:0,5',
        ]);

        $place = Place::findOrFail($id);

        if($place->isAuthor) {
            $place->name = $request->input('name');
            $place->geo_lat = number_format($request->input('geo_lat'), 6);
            $place->geo_lng = number_format($request->input('geo_lng'), 6);

            $place->save();

            $idStar = $place->starForUser()['id'];

            if ($idStar == 0)
            {
                $star = new PlaceStar();

                $star->place_id = $place->id;
                $star->user_id = Auth::user()->id;
            }
            else
            {
                $star = PlaceStar::findOrFail($idStar);
            }


            $star->stars = $request->input('stars');

            $star->save();

            $status_message = trans('gottashit.place.updated_place', ['place' =>  $place->name]);

            return redirect(route('place', ['language' => $language, 'place' => $place->id]))->with('status', $status_message);
        }
        else {
            $status_message = trans('gottashit.place.update_place_not_allowed', ['place' =>  $place->name]);

            return redirect(route('home', ['language' => $language]))->with('status', $status_message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($language, $id)
    {
        App::setLocale(Session::get('language', $language));

        $place = Place::withTrashed()->findOrFail($id);

        if($place->isAuthor)
        {
            $status_message = trans('gottashit.place.deleted_place', ['place' =>  $place->name]);

            if($place->trashed()){
                $status_message = trans('gottashit.place.deleted_place_permanently', ['place' =>  $place->name]);
                $place->forceDelete();
            }
            else{
                $place->delete();
            }

            return redirect(route('user_places', ['language' => $language]))->with('status', $status_message);
        }
        else {
            $status_message = trans('gottashit.place.delete_place_not_allowed', ['place' =>  $place->name]);

            return redirect(route('home', ['language' => $language]))->with('status', $status_message);
        }

    }

    public function restorePlace($language, $place_id)
    {
        App::setLocale(Session::get('language', $language));

        $place = Place::withTrashed()->findOrFail($place_id);

        if ($place->isAuthor) {
            $place->restore();

            $status_message = trans('gottashit.place.restored_place', ['place' =>  $place->name]);

            return redirect(route('place', ['language' => $language, 'place' => $place->id]))->with('status', $status_message);
        }
        else{
            $status_message = trans('gottashit.place.restore_place_not_allowed', ['place' =>  $place->name]);

            return redirect(route('home', ['language' => $language]))->with('status', $status_message);
        }
    }

    /**
     * Display a listing of the resource for the user
     *
     * @return Response
     */
    public function placesForUser($language)
    {
        App::setLocale(Session::get('language', $language));

        if(Auth::check())
        {
            $places = Place::where('user_id', Auth::user()->id)->paginate(8);
        }
        else
        {
            $places = Place::paginate(8);
        }

        return view('places', compact('places'));
    }

    public function bestPlaces($language)
    {
        App::setLocale(Session::get('language', $language));

        $places = Place::rightJoin('place_stars', 'place_stars.place_id', '=', 'places.id')
          ->select(DB::raw('places.*, sum(place_stars.stars)/count(place_stars.stars) AS star_average'))
          ->groupBy('places.id')
          ->orderBy('star_average', 'desc')
          ->paginate(8);

        return view('places', compact('places'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $latitude
     * @param $longitude
     * @param int $distance in meters
     */
    public function nearest(Request $request, $language, $latitude, $longitude, $distance)
    {
        App::setLocale(Session::get('language', $language));

        $totalLat = 180;
        $totalLng = 360;
        $radius = 6371000;
        $pi = pi();
        $totalMeters = 2 * $pi * $radius;

        $deltaLat = ($totalLat * $distance) / ($totalMeters / 2);
        $deltaLng = ($totalLng * $distance) / ($totalMeters);

        $places = Place::whereBetween('geo_lat', array($latitude - $deltaLat, $latitude + $deltaLat))
                        ->whereBetween('geo_lng', array($longitude - $deltaLng, $longitude + $deltaLng))
                        ->paginate(8);

        return view('places', compact('places'));
    }

}
