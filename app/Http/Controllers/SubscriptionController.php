<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Place $place)
    {
        $this->subscribe($place);

        return $this->responseView($request, $place);
    }

    public function destroy(Request $request, Place $place)
    {
        $this->unsubscribe($place);

        return $this->responseView($request, $place);
    }

    protected function subscribe(Place $place)
    {
        $subscription = new Subscription();
        $subscription->place_id = $place->id;
        $subscription->user_id = Auth::user()->id;
        $subscription->comment_id = null;
        $subscription->save();
    }

    protected function unsubscribe(Place $place)
    {
        $subscription = Subscription::where('user_id', Auth::user()->id)
            ->where('place_id', $place->id);

        $subscription->forceDelete();
    }

    public function responseView(Request $request, Place $place)
    {
        if ($request->getMethod() == "POST") {
            $statusMessage = trans('gottashit.subscription.subscribed_place');
            $view = "place.subscription.remove";
        }

        if ($request->getMethod() == "DELETE") {
            $statusMessage = trans('gottashit.subscription.unsubscribed_place');
            $view = "place.subscription.add";
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'status_message' => $statusMessage ?? '',
                'button_box' => view($view ?? '', compact('place'))->render(),
                'request' => $request->getMethod(),
            ]);
        } else {
            $placeRoute = route(
                'place.show',
                [
                    'place' => $place->id,
                ]
            );

            return redirect($placeRoute)
                ->with('status', $statusMessage);
        }
    }
}
