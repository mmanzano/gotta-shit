<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceStar;
use GottaShit\Http\Requests\PlaceDestroyRequest;
use GottaShit\Http\Requests\PlaceEditRequest;
use GottaShit\Http\Requests\PlaceShowRequest;
use GottaShit\Http\Requests\PlaceStoreRequest;
use GottaShit\Http\Requests\PlaceUpdateRequest;
use GottaShit\Jobs\ManagePlaceCreation;
use GottaShit\Repositories\PlaceRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\View\View;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'auth',
            [
                'only' => ['create', 'store', 'edit', 'update', 'destroy', 'restore', 'placesForUser'],
            ]
        );
    }

    public function index(string $language): View
    {
        return view('places', [
            'title' => trans('gottashit.title.all_places'),
            'places' => Place::paginate(8),
        ]);
    }

    public function show(PlaceShowRequest $request, string $language, $placeId): View
    {
        optional($request->place->auth_user_subscription)
            ->update(['comment_id' => null]);

        return view('place', [
            'title' => $request->place->name,
            'place' => $request->place,
        ]);
    }

    public function create(string $language): View
    {
        return view('place.create', [
            'title' => trans('gottashit.title.create_place'),
        ]);
    }

    public function store(PlaceStoreRequest $request, string $language): RedirectResponse
    {
        $place = Auth::user()
            ->places()
            ->create([
                'name' => request('name'),
                'geo_lat' => number_format(request('geo_lat'), 6),
                'geo_lng' => number_format(request('geo_lng'), 6),
            ]);

        ManagePlaceCreation::dispatch($place);

        $statusMessage = trans('gottashit.place.created_place', ['place' => $place->name]);

        return redirect($place->path)
            ->with('status', $statusMessage);
    }

    public function edit(PlaceEditRequest $request, string $language, Place $place): View
    {
        return view('place.edit', [
            'title' => trans('gottashit.title.edit_place', ['place' => $place->name]),
            'place' => $place,
        ]);
    }

    public function update(PlaceUpdateRequest $request, string $language, Place $place): RedirectResponse
    {
        $place->update([
            'name' => request('name'),
            'geo_lat' => number_format(request('geo_lat'), 6),
            'geo_lng' => number_format(request('geo_lng'), 6),
        ]);

        PlaceStar::updateOrCreate([
            'place_id' => $place->id,
            'user_id' => Auth::id(),
        ], ['stars' => request('stars')]);

        $statusMessage = trans('gottashit.place.updated_place', ['place' => $place->name]);

        return redirect($place->path)
            ->with('status', $statusMessage);
    }

    public function destroy(PlaceDestroyRequest $request, string $language, int $placeId): RedirectResponse
    {
        if ($request->place->trashed()) {
            $statusMessage = trans('gottashit.place.deleted_place_permanently', ['place' => $request->place->name]);

            $request->place->forceDelete();
        } else {
            $statusMessage = trans('gottashit.place.deleted_place', ['place' => $request->place->name]);

            $request->place->delete();
        }

        return redirect(route('user_places', ['language' => App::getLocale()]))
            ->with('status', $statusMessage);
    }

    public function restore(PlaceDestroyRequest $request, string $language, int $placeId): RedirectResponse
    {
        $request->place->restore();

        $statusMessage = trans('gottashit.place.restored_place', ['place' => $request->place->name]);

        return redirect($request->place->path)
            ->with('status', $statusMessage);
    }

    public function placesForUser(string $language): View
    {
        return view('places', [
            'title' => trans('gottashit.title.user_places'),
            'places' => Auth::user()->places()->paginate(8),
        ]);
    }

    public function bestPlaces(PlaceRepository $placeRepository, string $language): View
    {
        return view('places', [
            'title' => trans('gottashit.title.best_places'),
            'places' => $placeRepository
                ->bestPlaces()
                ->paginate(8),
        ]);
    }

    public function nearest(PlaceRepository $placeRepository, string $language, float $lat, float $lon, int $dist): View
    {
        return view('places', [
            'title' => trans('gottashit.title.nearest_places'),
            'places' => $placeRepository
                ->nearTo($lat, $lon, $dist)
                ->paginate(8),
        ]);
    }
}
