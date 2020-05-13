<?php

namespace App\Http\Responses;

use App\Entities\Place;
use App\Entities\PlaceComment;

class CommentStoreResponse extends GottaShitResponse
{
    /** @var PlaceComment */
    public $comment;

    /** @var Place */
    public $place;

    /** @var string */
    public $statusMessage;

    public function __construct(PlaceComment $comment)
    {
        $this->comment = $comment;
        $this->place = $comment->place;
        $this->statusMessage = trans('gottashit.comment.created_comment', ['place' => $this->comment->place->name]);
    }

    protected function toJson()
    {
        $numberOfComments = trans_choice(
            'gottashit.comment.comments',
            $this->comment->place->number_of_comments,
            ['number_of_comments' => $this->comment->place->number_of_comments]
        );

        return response()->json([
            'status' => 200,
            'status_message' => $this->statusMessage,
            'comment' => view('comment.view', [
                'place' => $this->place,
                'comment' => $this->comment,
            ])->render(),
            'number_of_comments' => $numberOfComments,
            'button_box' => view('place.subscription.remove', ['place' => $this->place])->render(),
        ]);
    }

    protected function toView()
    {
        return redirect($this->comment->path)
            ->with('status', $this->statusMessage);
    }
}
