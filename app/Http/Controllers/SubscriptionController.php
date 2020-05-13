<?php

namespace App\Http\Controllers;

use App\Entities\Place;
use App\Http\Responses\SubscriptionDestroyResponse;
use App\Http\Responses\SubscriptionStoreResponse;
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
