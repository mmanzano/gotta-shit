<?php

namespace GottaShit\Http\Responses;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;

class CommentEditResponse extends GottaShitResponse
{
    /** @var PlaceComment */
    public $comment;

    /** @var Place */
    public $place;

    public function __construct(PlaceComment $comment)
    {
        $this->comment = $comment;
        $this->place = $comment->place;
    }

    protected function toJson()
    {
        return response()->json([
            'edit_box' => view('comment.partials.edit', [
                'place' => $this->place,
                'comment' => $this->comment,
            ])->render(),
        ]);
    }

    protected function toView()
    {
        $title = trans('gottashit.nav.edit') . $this->place->name;

        return view('comment.edit', [
            'title' => $title,
            'place' => $this->place,
            'comment' => $this->comment,
        ]);
    }
}
