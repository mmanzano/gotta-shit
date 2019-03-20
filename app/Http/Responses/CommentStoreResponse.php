<?php

namespace GottaShit\Http\Responses;

use GottaShit\Entities\PlaceComment;

class CommentStoreResponse extends GottaShitResponse
{
    /** @var PlaceComment */
    public $comment;

    /** @var string */
    public $statusMessage;

    public function __construct($comment)
    {
        $this->comment = $comment;
        $this->place = $comment->place;
        $this->statusMessage = trans('gottashit.comment.created_comment', ['place' => $this->comment->place->name]);
    }

    protected function toJson()
    {
        $numberOfComments = trans_choice(
            'gottashit.comment.comments',
            $this->comment->place->numberOfComments,
            ['number_of_comments' => $this->comment->place->numberOfComments]
        );

        return response()->json([
            'status' => 200,
            'status_message' => $this->statusMessage,
            'comment' => view('place.comment.view', [
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
