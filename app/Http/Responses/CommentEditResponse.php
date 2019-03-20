<?php

namespace GottaShit\Http\Responses;

use GottaShit\Entities\PlaceComment;

class CommentEditResponse extends GottaShitResponse
{
    /** @var PlaceComment */
    public $comment;

    /** @var string */
    public $statusMessage;

    public function __construct($comment)
    {
        $this->comment = $comment;
        $this->place = $comment->place;
    }

    protected function toJson()
    {
        return response()->json([
            'edit_box' => view('place.comment.partials.edit', [
                'place' => $this->place,
                'comment' => $this->comment,
            ])->render(),
        ]);
    }

    protected function toView()
    {
        $title = trans('gottashit.nav.edit') . $this->place->name;

        return view('place.comment.edit', [
            'title' => $title,
            'place' => $this->place,
            'comment' => $this->comment,
        ]);
    }
}
