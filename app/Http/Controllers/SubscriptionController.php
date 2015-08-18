<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Subscription;
use GottaShit\Http\Requests;
use GottaShit\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{

    public function store($language, $place_id){
        App::setLocale(Session::get('language', $language));
        $language = App::getLocale();

        $this->subscribe($place_id);

        $status_message = trans('gottashit.subscription.subscribed_place');

        return $this->responseView($language, $place_id, $status_message);
    }

    public function destroy($language, $place_id){
        App::setLocale(Session::get('language', $language));
        $language = App::getLocale();

        $this->unsubscribe($place_id);

        $status_message = trans('gottashit.subscription.unsubscribed_place');

        return $this->responseView($language, $place_id, $status_message);
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

    public function responseView($language, $place_id, $status_message) {
        return redirect(route('place', ['language' => $language, 'place' => $place_id]))->with('status', $status_message);
    }

}
