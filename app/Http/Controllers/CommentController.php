<?php

namespace App\Http\Controllers;

use App\Entities\Place;
use App\Entities\PlaceComment;
use App\Http\Requests\CommentDestroyRequest;
use App\Http\Requests\CommentEditRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Responses\CommentDestroyResponse;
use App\Http\Responses\CommentEditResponse;
use App\Http\Responses\CommentStoreResponse;
use App\Http\Responses\CommentUpdateResponse;
use App\Jobs\ManageSubscriptions;
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
