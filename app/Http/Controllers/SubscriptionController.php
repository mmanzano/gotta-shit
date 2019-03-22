<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Http\Responses\SubscriptionDestroyResponse;
use GottaShit\Http\Responses\SubscriptionStoreResponse;
use Illuminate\Support\Facades\Auth as Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Place $place): SubscriptionStoreResponse
    {
        Auth::user()->updateOrCreateSubscription($place);

        return new SubscriptionStoreResponse($place);
    }

    public function destroy(Place $place): SubscriptionDestroyResponse
    {
        Auth::user()->deleteSubscription($place);

        return new SubscriptionDestroyResponse($place);
    }
}
