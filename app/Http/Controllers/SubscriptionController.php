<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\Subscription;
use GottaShit\Http\Requests;
use GottaShit\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{

    public function store(Request $request, $language, $place_id){
        App::setLocale(Session::get('language', $language));

        $this->subscribe($place_id);

        return $this->responseView($request, $place_id);
    }

    public function destroy(Request $request, $language, $place_id){
        App::setLocale(Session::get('language', $language));

        $this->unsubscribe($place_id);

        return $this->responseView($request, $place_id);
    }

    protected function subscribe($place_id)
    {
        $subscription = new Subscription();
        $subscription->place_id = $place_id;
        $subscription->user_id = Auth::user()->id;
        $subscription->comment_id = null;
        $subscription->save();
    }

    protected function unsubscribe($place_id)
    {
        $subscription = Subscription::where('user_id', Auth::user()->id)->where('place_id', $place_id);
        $subscription->forceDelete();
    }

    public function responseView(Request $request, $place_id) {
        $language = App::getLocale();
        $status_message = "";
        $view = "";
        $place = Place::findOrFail($place_id);

        if($request->getMethod() == "POST") {
            $status_message = trans('gottashit.subscription.subscribed_place');
            $view = "place.subscription.remove";
        }
        else if($request->getMethod() == "DELETE") {
            $status_message = trans('gottashit.subscription.unsubscribed_place');
            $view = "place.subscription.add";
        }

        if($request->ajax()){
            return response()->json([
              'status' => 200,
              'status_message' => $status_message,
              'button_box' => view($view, compact('place'))->render(),
              'request' => $request->getMethod(),
            ]);
        }
        else {
            return redirect(route('place', ['language' => $language, 'place' => $place_id]))->with('status', $status_message);
        }
    }

}
