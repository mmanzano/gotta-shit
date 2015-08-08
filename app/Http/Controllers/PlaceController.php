<?php namespace GottaShit\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth;

use GottaShit\Http\Requests;
use GottaShit\Http\Controllers\Controller;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceStar;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\User;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $places = Place::paginate(8);

        return view('places', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('place.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
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
        $place->user_id = \Auth::User()->id;
        
        $place->save();

        $star = new PlaceStar();

        $star->place_id = $place->id;
        $star->user_id = \Auth::User()->id;
        $star->stars = $request->input('stars');

        $star->save();

        $status_message = trans('gottashit.place.created_place', ['place' =>  $place->name]);

        return redirect('/place/' . $place->id)->with('status', $status_message);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $place = Place::findOrFail($id);

        return view('place', compact('place'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
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
    public function update(Request $request, $id)
    {

        $this->validate($request, [
          'name' => 'required|max:255',
          'geo_lat' => 'required|numeric|between:-90,90',
          'geo_lng' => 'required|numeric|between:-180,180',
          'stars' => 'required|numeric|between:0,5',
        ]);

        $place = Place::findOrFail($id);

        $place->name = $request->input('name');
        $place->geo_lat = number_format($request->input('geo_lat'), 6);
        $place->geo_lng = number_format($request->input('geo_lng'), 6);

        $place->save();

        $idStar = $place->starForUser()['id'];

        if ($idStar == 0)
        {
            $star = new PlaceStar();

            $star->place_id = $place->id;
            $star->user_id = \Auth::User()->id;
        }
        else
        {
            $star = PlaceStar::findOrFail($idStar);
        }


        $star->stars = $request->input('stars');

        $star->save();

        $status_message = trans('gottashit.place.updated_place', ['place' =>  $place->name]);

        return redirect('/place/' . $place->id)->with('status', $status_message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $place = Place::findOrFail($id);

        $status_message = trans('gottashit.place.deleted_place', ['place' =>  $place->name]);

        $place->delete();

        return redirect('/')->with('status', $status_message);
    }

    /**
     * Display a listing of the resource for the user
     *
     * @return Response
     */
    public function placesForUser()
    {
        if(\Auth::check())
        {
            $places = Place::where('user_id', \Auth::User()->id)->paginate(8);
        }
        else
        {
            $places = Place::paginate(8);
        }

        return view('places', compact('places'));
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param $latitude
     * @param $longitude
     * @param int $distance in meters
     */
    public function nearest(Request $request, $latitude, $longitude, $distance)
    {
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
