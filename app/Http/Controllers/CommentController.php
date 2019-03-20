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

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentStoreRequest $request
     * @param string $language
     * @param Place $place
     * @return CommentStoreResponse
     */
    public function store(CommentStoreRequest $request, string $language, Place $place)
    {
        $comment = Auth::user()
            ->comments()
            ->create([
                'comment' => $request->input('comment'),
                'place_id' => $place->id,
            ]);

        ManageSubscriptions::dispatch($place, $comment);

        return new CommentStoreResponse($comment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CommentEditRequest $request
     * @param string $language
     * @param Place $place
     * @param PlaceComment $comment
     * @return CommentEditResponse
     */
    public function edit(CommentEditRequest $request, string $language, Place $place, PlaceComment $comment)
    {
        return new CommentEditResponse($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommentUpdateRequest $request
     * @param string $language
     * @param Place $place
     * @param PlaceComment $comment
     * @return CommentUpdateResponse
     */
    public function update(CommentUpdateRequest $request, string $language, Place $place, PlaceComment $comment)
    {
        $comment->update([
            'comment' => $request->input('comment'),
        ]);

        return new CommentUpdateResponse($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CommentDestroyRequest $request
     * @param string $language
     * @param Place $place
     * @param PlaceComment $comment
     * @return CommentDestroyResponse
     */
    public function destroy(CommentDestroyRequest $request, string $language, Place $place, PlaceComment $comment)
    {
        $comment->forceDelete();

        return new CommentDestroyResponse($place);
    }
}
