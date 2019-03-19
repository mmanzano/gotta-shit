<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceStar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth as Auth;

class StarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $language
     * @param Place $place
     * @return Response
     * @throws \Throwable
     */
    public function update(Request $request, string $language, Place $place)
    {
        $this->validate($request, [
            'stars' => 'required|numeric|between:0,5',
        ]);

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

        $statusMessage = trans('gottashit.star.rated', ['place' => $place->name]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'status_message' => $statusMessage,
                'star_width' => $place->stars_progress_bar,
                'star_text' => $place->stars_average . ' / ' . trans('gottashit.star.votes') . ': '
                    . $place->stars_amount,
                'button_delete_rate' => view('place.partials.delete_rate', compact('place'))->render(),
            ]);
        } else {
            $placeRoute = route(
                'place.show',
                [
                    'language' => App::getLocale(),
                    'place' => $place->id,
                ]
            );

            return redirect($placeRoute)
                ->with('status', $statusMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param string $language
     * @param Place $place
     * @return Response
     */
    public function destroy(Request $request, string $language, Place $place)
    {
        $idStar = $place->id_of_user_star;

        if ($idStar != 0) {
            $star = PlaceStar::findOrFail($idStar);
        }

        $statusMessage = trans('gottashit.star.deleted_star', ['place' => $place->name]);

        $star->forceDelete();

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'status_message' => $statusMessage,
                'star_width' => $place->stars_progress_bar,
                'star_text' => $place->stars_average . ' / ' . trans('gottashit.star.votes') . ': '
                    . $place->stars_amount,
            ]);
        } else {
            $placeRoute = route(
                'place.show',
                [
                    'language' => App::getLocale(),
                    'place' => $place->id,
                ]
            );

            return redirect($placeRoute)
                ->with('status', $statusMessage);
        }
    }
}
