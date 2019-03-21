<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Http\Requests\CommentDestroyRequest;
use GottaShit\Http\Requests\CommentEditRequest;
use GottaShit\Http\Requests\CommentStoreRequest;
use GottaShit\Http\Requests\CommentUpdateRequest;
use GottaShit\Http\Responses\CommentDestroyResponse;
use GottaShit\Http\Responses\CommentEditResponse;
use GottaShit\Http\Responses\CommentStoreResponse;
use GottaShit\Http\Responses\CommentUpdateResponse;
use GottaShit\Jobs\ManageSubscriptions;
use Illuminate\Support\Facades\Auth as Auth;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['store', 'edit', 'update', 'destroy']]);
    }

    public function store(CommentStoreRequest $request): CommentStoreResponse
    {
        $place = Place::findOrFail(request('placeId'));

        $comment = Auth::user()
            ->comments()
            ->create([
                'comment' => request('comment'),
                'place_id' => $place->id,
            ]);

        ManageSubscriptions::dispatch($place, $comment);

        return new CommentStoreResponse($comment);
    }

    public function edit(CommentEditRequest $request, PlaceComment $comment): CommentEditResponse
    {
        return new CommentEditResponse($comment);
    }

    public function update(CommentUpdateRequest $request, PlaceComment $comment): CommentUpdateResponse
    {
        $comment->update([
            'comment' => $request->input('comment'),
        ]);

        return new CommentUpdateResponse($comment);
    }

    public function destroy(CommentDestroyRequest $request, PlaceComment $comment): CommentDestroyResponse
    {
        $place = $comment->place;

        $comment->forceDelete();

        return new CommentDestroyResponse($place);
    }
}
