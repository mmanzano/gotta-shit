<?php

namespace GottaShit\Http\Controllers;

use Carbon\Carbon;
use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceStar;
use GottaShit\Entities\Subscription;
use GottaShit\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store', 'update', 'destroy', 'restore', 'placesForUser']]);

        $this->middleware('isAuthor', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $language
     * @return Response
     */
    public function index(string $language)
    {
        $places = Place::paginate(8);

        $title = trans('gottashit.title.all_places');

        return view('places', compact('title', 'places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $language
     * @return Response
     */
    public function create(string $language)
    {
        $title = trans('gottashit.title.create_place');

        return view('place.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param AppMailer $mailer
     * @param string $language
     * @return Response
     */
    public function store(Request $request, AppMailer $mailer, string $language)
    {
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

        $mailer->sendPlaceAddNotification(
            Auth::user(),
            $place,
            trans('gottashit.email.new_place_add')
        );

        $statusMessage = trans('gottashit.place.created_place', ['place' => $place->name]);

        $placeRoute = route(
            'place.show',
            ['language' => App::getLocale(), 'place' => $place->id]
        );

        return redirect($placeRoute)
            ->with('status', $statusMessage);
    }

    /**
     * Display the specified resource.
     *
     * @param string $language
     * @param int $placeId
     * @return Response
     */
    public function show(string $language, $placeId)
    {
        $place = Place::withTrashed()->findOrFail($placeId);

        $title = $place->name;

        if ($place->trashed() && !$place->isAuthor) {
            return redirect(route('home'));
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
     * @param string $language
     * @param Place $place
     * @return Response
     */
    public function edit(string $language, Place $place)
    {
        $title = trans('gottashit.title.edit_place', ['place' => $place->name]);

        return view('place.edit', compact('title', 'place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $language
     * @param Place $place
     * @return Response
     */
    public function update(Request $request, string $language, Place $place)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'geo_lat' => 'required|numeric|between:-90,90|distinct_place_update',
            'geo_lng' => 'required_with:geo_lat|numeric|between:-180,180',
            'stars' => 'required|numeric|between:0,5',
        ]);

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

            $statusMessage = trans('gottashit.place.updated_place', ['place' => $place->name]);

            $placeRoute = route(
                'place.show',
                [
                    'language' => App::getLocale(),
                    'place' => $place->id,
                ]
            );

            return redirect($placeRoute)
                ->with('status', $statusMessage);
        } else {
            $statusMessage = trans('gottashit.place.update_place_not_allowed', ['place' => $place->name]);

            $homeRoute = route('home');

            return redirect($homeRoute)
                ->with('status', $statusMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $language
     * @param int $placeId
     * @return Response
     */
    public function destroy(string $language, int $placeId)
    {
        $place = Place::withTrashed()->findOrFail($placeId);

        if ($place->isAuthor) {
            $statusMessage = trans('gottashit.place.deleted_place', ['place' => $place->name]);

            if ($place->trashed()) {
                $statusMessage = trans('gottashit.place.deleted_place_permanently', ['place' => $place->name]);

                $place->forceDelete();
            } else {
                $place->delete();
            }

            $placesForUserRoute = route('user_places', ['language' => App::getLocale()]);

            return redirect($placesForUserRoute)
                ->with('status', $statusMessage);
        } else {
            $statusMessage = trans('gottashit.place.delete_place_not_allowed', ['place' => $place->name]);

            $homeRoute = route('home');

            return redirect($homeRoute)
                ->with('status', $statusMessage);
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param string $language
     * @param int $placeId
     * @return Response
     */
    public function restore(string $language, int $placeId)
    {
        $place = Place::withTrashed()->findOrFail($placeId);

        if ($place->isAuthor) {
            $place->restore();

            $statusMessage = trans('gottashit.place.restored_place', ['place' => $place->name]);

            $placeRoute = route(
                'place.show',
                [
                    'language' => App::getLocale(),
                    'place' => $place->id,
                ]
            );

            return redirect($placeRoute)
                ->with('status', $statusMessage);
        } else {
            $statusMessage = trans('gottashit.place.restore_place_not_allowed', ['place' => $place->name]);

            $homeRoute = route('home');

            return redirect($homeRoute)
                ->with('status', $statusMessage);
        }
    }

    /**
     * Display a listing of the resource for the user
     *
     * @param string $language
     * @return Response
     */
    public function placesForUser(string $language)
    {
        if (Auth::check()) {
            $places = Place::where('user_id', Auth::user()->id)->paginate(8);
        } else {
            $places = Place::paginate(8);
        }

        $title = trans('gottashit.title.user_places');

        return view('places', compact('title', 'places'));
    }

    /**
     * Display a listing of the best resources
     *
     * @param string $language
     * @return Response
     */
    public function bestPlaces(string $language)
    {
        $places = Place::rightJoin('place_stars', 'place_stars.place_id', '=', 'places.id')
            ->select(DB::raw('places.*, sum(place_stars.stars)/count(place_stars.stars) AS star_average'))
            ->groupBy('places.id')
            ->orderBy('star_average', 'desc')
            ->paginate(8);

        $title = trans('gottashit.title.best_places');

        return view('places', compact('title', 'places'));
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $distance in meters
     *
     * @return Response
     */
    public function nearest(
        string $language,
        float $latitude,
        float $longitude,
        int $distance
    ) {
        $totalLat = 180;
        $totalLng = 360;
        $radius = 6371000;
        $pi = pi();
        $totalMeters = 2 * $pi * $radius;

        $deltaLat = ($totalLat * $distance) / ($totalMeters / 2);
        $deltaLng = ($totalLng * $distance) / ($totalMeters);

        $places = Place::whereBetween('geo_lat', [$latitude - $deltaLat, $latitude + $deltaLat])
            ->whereBetween('geo_lng', [$longitude - $deltaLng, $longitude + $deltaLng])
            ->paginate(8);

        $title = trans('gottashit.title.nearest_places');

        return view('places', compact('title', 'places'));
    }
}
