<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceStar;
use GottaShit\Http\Requests\StartUpdateRequest;
use GottaShit\Http\Responses\StarDestroyResponse;
use GottaShit\Http\Responses\StarUpdateResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;

class StarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(StartUpdateRequest $request, Place $place): StarUpdateResponse
    {
        PlaceStar::updateOrCreate([
            'place_id' => $place->id,
            'user_id' => Auth::id(),
        ], ['stars' => request('stars')]);

        return new StarUpdateResponse($place);
    }

    public function destroy(Place $place): StarDestroyResponse
    {
        PlaceStar::where([
            'place_id' => $place->id,
            'user_id' => Auth::id(),
        ])->forceDelete();

        return new StarDestroyResponse($place);
    }
}
