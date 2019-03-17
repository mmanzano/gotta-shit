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
     * @param $language
     * @param $id_place
     * @return Response
     * @throws \Throwable
     */
    public function update(Request $request, $language, $id_place)
    {
        $this->setLanguage($language);

        $this->validate($request, [
            'stars' => 'required|numeric|between:0,5',
        ]);

        $place = Place::findOrFail($id_place);

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

        $status_message = trans('gottashit.star.rated',
            ['place' => $place->name]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'status_message' => $status_message,
                'star_width' => $place->stars_progress_bar,
                'star_text' => $place->stars_average . ' / ' . trans('gottashit.star.votes') . ': ' . $place->stars_amount,
                'button_delete_rate' => view('place.partials.delete_rate',
                    compact('place'))->render(),
            ]);
        } else {
            return redirect(route('place.show',
                [
                    'language' => $language,
                    'place' => $place->id,
                ]))->with('status',
                $status_message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $language
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $language, $id)
    {
        $this->setLanguage($language);

        $place = Place::findOrFail($id);

        $idStar = $place->id_of_user_star;

        if ($idStar != 0) {
            $star = PlaceStar::findOrFail($idStar);
        }

        $status_message = trans('gottashit.star.deleted_star',
            ['place' => $place->name]);

        $star->forceDelete();

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'status_message' => $status_message,
                'star_width' => $place->stars_progress_bar,
                'star_text' => $place->stars_average . ' / ' . trans('gottashit.star.votes') . ': ' . $place->stars_amount,
            ]);
        } else {
            return redirect(route('place.show',
                [
                    'language' => $language,
                    'place' => $place->id,
                ]))->with('status',
                $status_message);
        }
    }
}
