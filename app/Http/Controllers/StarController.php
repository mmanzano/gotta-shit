<?php

namespace App\Http\Controllers;

use App\Entities\Place;
use App\Entities\PlaceStar;
use App\Http\Requests\StartUpdateRequest;
use App\Http\Responses\StarDestroyResponse;
use App\Http\Responses\StarUpdateResponse;
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
