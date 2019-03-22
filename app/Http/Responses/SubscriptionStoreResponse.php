<?php

namespace GottaShit\Http\Responses;

use GottaShit\Entities\Place;

class SubscriptionStoreResponse extends GottaShitResponse
{
    /** @var Place */
    public $place;

    /** @var string */
    public $statusMessage;

    public function __construct(Place $place)
    {
        $this->place = $place;
        $this->statusMessage = trans('gottashit.subscription.subscribed_place');
    }

    protected function toJson()
    {
        return response()->json([
            'status' => 200,
            'status_message' => $this->statusMessage,
            'button_box' => view('place.subscription.remove', [
                'place' => $this->place,
            ])->render(),
            'request' => 'POST',
        ]);
    }

    protected function toView()
    {
        return redirect($this->place->path)
            ->with('status', $this->statusMessage);
    }
}