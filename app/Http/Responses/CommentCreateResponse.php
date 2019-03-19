<?php

namespace GottaShit\Http\Responses;

use GottaShit\Entities\PlaceComment;

class CommentCreateResponse
{
    /** @var PlaceComment */
    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function response()
    {
        $statusMessage = trans('gottashit.comment.created_comment', ['place' => $this->comment->place->name]);

        if (request()->ajax()) {
            $numberOfComments = trans_choice(
                'gottashit.comment.comments',
                $this->comment->place->numberOfComments,
                ['number_of_comments' => $this->comment->place->numberOfComments]
            );

            return response()->json([
                'status' => 200,
                'status_message' => $statusMessage,
                'comment' => view('place.comment.view', compact('place', 'comment'))->render(),
                'number_of_comments' => $numberOfComments,
                'button_box' => view('place.subscription.remove', compact('place'))->render(),
            ]);
        }

        return redirect($this->comment->path)
            ->with('status', $statusMessage);
    }
}
