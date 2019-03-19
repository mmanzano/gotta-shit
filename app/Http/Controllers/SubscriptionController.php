<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, string $language, Place $place)
    {
        $this->subscribe($place->id);

        return $this->responseView($request, $place);
    }

    public function destroy(Request $request, string $language, Place $place)
    {
        $this->unsubscribe($place->id);

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
        $language = App::getLocale();
        $status_message = "";
        $view = "";

        if ($request->getMethod() == "POST") {
            $status_message = trans('gottashit.subscription.subscribed_place');
            $view = "place.subscription.remove";
        } else {
            if ($request->getMethod() == "DELETE") {
                $status_message = trans('gottashit.subscription.unsubscribed_place');
                $view = "place.subscription.add";
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'status_message' => $status_message,
                'button_box' => view($view, compact('place'))->render(),
                'request' => $request->getMethod(),
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
