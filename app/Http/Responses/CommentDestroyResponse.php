<?php

namespace App\Http\Responses;

use App\Entities\Place;

class CommentDestroyResponse extends GottaShitResponse
{
    /** @var Place */
    public $place;

    /** @var string */
    public $statusMessage;

    public function __construct(Place $place)
    {
        $this->place = $place;
        $this->statusMessage = trans('gottashit.comment.deleted_comment', ['place' => $place->name]);
    }

    protected function toJson()
    {
        $numberOfComments = trans_choice(
            'gottashit.comment.comments',
            $this->place->number_of_comments,
            ['number_of_comments' => $this->place->number_of_comments]
        );

        return response()->json([
            'status' => 200,
            'status_message' => $this->statusMessage,
            'number_of_comments' => $numberOfComments,
        ]);
    }

    protected function toView()
    {
        return redirect($this->place->path)
            ->with('status', $this->statusMessage);
    }
}
