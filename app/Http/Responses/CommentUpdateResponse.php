<?php

namespace GottaShit\Http\Responses;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;

class CommentUpdateResponse extends GottaShitResponse
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
        $this->statusMessage = trans('gottashit.comment.updated_comment', ['place' => $this->place->name]);
    }

    protected function toJson()
    {
        $numberOfComments = trans_choice(
            'gottashit.comment.comments',
            $this->place->numberOfComments,
            ['number_of_comments' => $this->place->numberOfComments]
        );

        return response()->json([
            'status' => 200,
            'status_message' => $this->statusMessage,
            'comment' => view('comment.view', [
                'place' => $this->place,
                'comment' => $this->comment,
            ])->render(),
            'number_of_comments' => $numberOfComments,
        ]);
    }

    protected function toView()
    {
        return redirect($this->comment->path)
            ->with('status', $this->statusMessage);
    }
}