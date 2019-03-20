<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Http\Requests\CommentEditRequest;
use GottaShit\Http\Requests\CommentStoreRequest;
use GottaShit\Http\Responses\CommentStoreResponse;
use GottaShit\Http\Responses\CommentEditResponse;
use GottaShit\Jobs\ManageSubscriptions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['store', 'update', 'destroy']]);

        $this->middleware('isAuthorComment', ['only' => ['edit']]);
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
     * @param Request $request
     * @param string $language
     * @param Place $place
     * @param PlaceComment $comment
     * @return Response
     * @throws \Throwable
     */
    public function update(Request $request, string $language, Place $place, PlaceComment $comment)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);

        if ($comment->isAuthor) {
            $comment->update([
                'comment' => $request->input('comment'),
            ]);

            $statusMessage = trans('gottashit.comment.updated_comment', ['place' => $place->name]);
        } else {
            $statusMessage = trans('gottashit.comment.update_comment_not_allowed', ['place' => $place->name]);
        }

        if ($request->ajax()) {
            $numberOfComments = trans_choice(
                'gottashit.comment.comments',
                $place->numberOfComments,
                ['number_of_comments' => $place->numberOfComments]
            );

            return response()->json([
                'status' => 200,
                'status_message' => $statusMessage,
                'comment' => view('place.comment.view', compact('place', 'comment'))->render(),
                'number_of_comments' => $numberOfComments,
            ]);
        }

        return redirect($comment->path)
            ->with('status', $statusMessage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param string $language
     * @param Place $place
     * @param PlaceComment $comment
     * @return Response
     */
    public function destroy(Request $request, string $language, Place $place, PlaceComment $comment)
    {
        if ($comment->isAuthor || $place->isAuthor) {
            $statusMessage = trans(
                'gottashit.comment.deleted_comment',
                ['place' => $place->name]
            );

            $comment->forceDelete();
        } else {
            $statusMessage = trans(
                'gottashit.comment.delete_comment_not_allowed',
                ['place' => $place->name]
            );
        }

        if ($request->ajax()) {
            $number_of_comments = trans_choice(
                'gottashit.comment.comments',
                $place->numberOfComments,
                ['number_of_comments' => $place->numberOfComments]
            );

            return response()->json([
                'status' => 200,
                'status_message' => $statusMessage,
                'number_of_comments' => $number_of_comments,
            ]);
        } else {
            $placeRoute = route(
                'place.show',
                [
                    'language' => App::getLocale(),
                    'place' => $place->id,
                ]
            );

            return redirect($placeRoute)
                ->with('status', $statusMessage);
        }
    }
}
