<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\PlaceStar;
use GottaShit\Entities\Subscription;
use GottaShit\Entities\User;
use GottaShit\Http\Requests;
use GottaShit\Http\Controllers\Controller;
use GottaShit\Mailers\AppMailer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PlaceController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['only' => ['create', 'store', 'update', 'destroy', 'restore', 'placesForUser']]);

        $this->middleware('isAuthor', ['only' => ['edit']]);
   }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($language)
    {
        $this->setLanguage($language);

        $places = Place::paginate(8);

        $title = trans('gottashit.title.all_places');

        return view('places', compact('title', 'places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($language)
    {
        $this->setLanguage($language);

        $title = trans('gottashit.title.create_place');

        return view('place.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, AppMailer $mailer, $language)
    {
        $this->setLanguage($language);

        $this->validate($request, [
            'name' => 'required|max:255',
            'geo_lat' => 'required|numeric|between:-90,90|distinct_place_store',
            'geo_lng' => 'required_with:geo_lat|numeric|between:-180,180',
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

        $subscription = new Subscription();
        $subscription->user_id = Auth::user()->id;
        $subscription->place_id = $place->id;
        $subscription->comment_id = null;
        $subscription->save();

        $mailer->sendPlaceAddNotification(Auth::user(), $place,
            trans('gottashit.email.new_place_add'));

        $status_message = trans('gottashit.place.created_place',
            ['place' => $place->name]);

        return redirect(route('place.show',
            ['language' => $language, 'place' => $place->id]))->with('status',
            $status_message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($language, $id)
    {
        $this->setLanguage($language);

        $place = Place::withTrashed()->findOrFail($id);

        $title = $place->name;

        if ($place->trashed() && !$place->isAuthor) {
            return redirect(route('home', ['language' => $language]));
        }

        Carbon::setLocale(App::getLocale());

        if (Auth::check()) {
            $user = Auth::user();
            $subscriptions = $user->subscriptions()->getResults();

            foreach ($subscriptions as $subscription) {
                if (($subscription->user_id == $user->id) && (!$subscription->comment)) {
                    $subscription->comment_id = null;
                    $subscription->save();
                }
            }
        }

        return view('place', compact('title', 'place'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($language, $id)
    {
        $this->setLanguage($language);

        $place = Place::findOrFail($id);

        $title = trans('gottashit.title.edit_place', ['place' => $place->name]);

        return view('place.edit', compact('title', 'place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $language, $id)
    {
        $this->setLanguage($language);

        $this->validate($request, [
            'name' => 'required|max:255',
            'geo_lat' => 'required|numeric|between:-90,90|distinct_place_update',
            'geo_lng' => 'required_with:geo_lat|numeric|between:-180,180',
            'stars' => 'required|numeric|between:0,5',
        ]);

        $place = Place::findOrFail($id);

        if ($place->isAuthor) {
            $place->name = $request->input('name');
            $place->geo_lat = number_format($request->input('geo_lat'), 6);
            $place->geo_lng = number_format($request->input('geo_lng'), 6);

            $place->save();

            $idStar = $place->id_of_user_star;

            if ($idStar == 0) {
                $star = new PlaceStar();

                $star->place_id = $place->id;
                $star->user_id = Auth::user()->id;
            } else {
                $star = PlaceStar::findOrFail($idStar);
            }


            $star->stars = $request->input('stars');

            $star->save();

            $status_message = trans('gottashit.place.updated_place',
                ['place' => $place->name]);

            return redirect(route('place.show',
                [
                    'language' => $language,
                    'place' => $place->id
                ]))->with('status',
                $status_message);
        } else {
            $status_message = trans('gottashit.place.update_place_not_allowed',
                ['place' => $place->name]);

            return redirect(route('home',
                ['language' => $language]))->with('status', $status_message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($language, $id)
    {
        $this->setLanguage($language);

        $place = Place::withTrashed()->findOrFail($id);

        if ($place->isAuthor) {
            $status_message = trans('gottashit.place.deleted_place',
                ['place' => $place->name]);

            if ($place->trashed()) {
                $status_message = trans('gottashit.place.deleted_place_permanently',
                    ['place' => $place->name]);
                $place->forceDelete();
            } else {
                $place->delete();
            }

            return redirect(route('user_places',
                ['language' => $language]))->with('status', $status_message);
        } else {
            $status_message = trans('gottashit.place.delete_place_not_allowed',
                ['place' => $place->name]);

            return redirect(route('home',
                ['language' => $language]))->with('status', $status_message);
        }
    }

    public function restore($language, $place_id)
    {
        $this->setLanguage($language);

        $place = Place::withTrashed()->findOrFail($place_id);

        if ($place->isAuthor) {
            $place->restore();

            $status_message = trans('gottashit.place.restored_place',
                ['place' => $place->name]);

            return redirect(route('place.show',
                [
                    'language' => $language,
                    'place' => $place->id
                ]))->with('status',
                $status_message);
        } else {
            $status_message = trans('gottashit.place.restore_place_not_allowed',
                ['place' => $place->name]);

            return redirect(route('home',
                ['language' => $language]))->with('status', $status_message);
        }
    }

    /**
     * Display a listing of the resource for the user
     *
     * @return Response
     */
    public function placesForUser($language)
    {
        $this->setLanguage($language);

        if (Auth::check()) {
            $places = Place::where('user_id', Auth::user()->id)->paginate(8);
        } else {
            $places = Place::paginate(8);
        }

        $title = trans('gottashit.title.user_places');

        return view('places', compact('title', 'places'));
    }

    public function bestPlaces($language)
    {
        $this->setLanguage($language);

        $places = Place::rightJoin('place_stars', 'place_stars.place_id', '=',
            'places.id')
            ->select(DB::raw('places.*, sum(place_stars.stars)/count(place_stars.stars) AS star_average'))
            ->groupBy('places.id')
            ->orderBy('star_average', 'desc')
            ->paginate(8);

        $title = trans('gottashit.title.best_places');

        return view('places', compact('title', 'places'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $latitude
     * @param $longitude
     * @param int $distance in meters
     *
     * @return Response
     */
    public function nearest(
        Request $request,
        $language,
        $latitude,
        $longitude,
        $distance
    ) {
        $this->setLanguage($language);

        $totalLat = 180;
        $totalLng = 360;
        $radius = 6371000;
        $pi = pi();
        $totalMeters = 2 * $pi * $radius;

        $deltaLat = ($totalLat * $distance) / ($totalMeters / 2);
        $deltaLng = ($totalLng * $distance) / ($totalMeters);

        $places = Place::whereBetween('geo_lat',
            array($latitude - $deltaLat, $latitude + $deltaLat))
            ->whereBetween('geo_lng',
                array($longitude - $deltaLng, $longitude + $deltaLng))
            ->paginate(8);

        $title = trans('gottashit.title.nearest_places');

        return view('places', compact('title', 'places'));
    }
}
