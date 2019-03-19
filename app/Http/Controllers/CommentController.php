<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\Subscription;
use GottaShit\Http\Requests\CommentStoreRequest;
use GottaShit\Mailers\AppMailer;
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
     * @param AppMailer $mailer
     * @param string $language
     * @param Place $place
     * @return Response
     * @throws \Throwable
     */
    public function store(
        CommentStoreRequest $request,
        AppMailer $mailer,
        string $language,
        Place $place
    ) {
        $comment = PlaceComment::create([
            'place_id' => $place->id,
            'user_id' => Auth::id(),
            'comment' => $request->input('comment'),
        ]);

        $subscription_number = Subscription::where('user_id', Auth::id())
            ->where('place_id', $place->id)
            ->count();

        if (!$subscription_number) {
            Subscription::create([
                'user_id' => Auth::id(),
                'place_id' => $place->id,
                'comment_id' => null,
            ]);
        }

        $place->subscriptions->filter(function ($subscription) {
            return $subscription->user_id != Auth::id() && is_null($subscription->comment_id);
        })->each(function ($subscription) use ($mailer, $place, $comment) {
            $mailer->sendCommentAddNotification(
                Auth::user(),
                $subscription->user,
                $place,
                $comment,
                $subscription,
                trans('gottashit.email.new_comment_add', ['place' => $place->name], $subscription->user->language)
            );
        });

        $place->subscriptions()
            ->where('user_id', Auth::id())
            ->update([
                'comment_id' => null,
            ]);

        $statusMessage = trans('gottashit.comment.created_comment', ['place' => $place->name]);

        if ($request->ajax()) {
            $numberOfComments = trans_choice(
                'gottashit.comment.comments',
                $place->numberOfComments,
                ['number_of_comments' => $place->numberOfComments]
            );

            return response()->json([
                'status' => 200,
                'status_message' => $statusMessage,
                'comment' => view('place.comment.view',
                    compact('place', 'comment'))->render(),
                'number_of_comments' => $numberOfComments,
                'button_box' => view('place.subscription.remove',
                    compact('place'))->render(),
            ]);
        } else {
            $route = route('place.show', [
                'language' => App::getLocale(),
                'place' => $place->id,
            ]);

            $routeWithAnchor = $route . '#comment-' . $comment->id;

            return redirect($routeWithAnchor)
                ->with('status', $statusMessage);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param string $language
     * @param Place $place
     * @param PlaceComment $comment
     * @return Response
     * @throws \Throwable
     */
    public function edit(Request $request, string $language, Place $place, PlaceComment $comment)
    {
        $title = trans('gottashit.nav.edit') . $place->name;

        if ($request->ajax()) {
            return response()->json([
                'edit_box' => view('place.comment.partials.edit',
                    compact('place', 'comment'))->render(),
            ]);
        } else {
            return view('place.comment.edit',
                compact('title', 'place', 'comment'));
        }
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
            $comment->comment = $request->input('comment');

            $comment->save();

            $status_message = trans('gottashit.comment.updated_comment',
                ['place' => $place->name]);
        } else {
            $status_message = trans('gottashit.comment.update_comment_not_allowed',
                ['place' => $place->name]);
        }

        if ($request->ajax()) {
            $number_of_comments = trans_choice('gottashit.comment.comments',
                $place->numberOfComments,
                ['number_of_comments' => $place->numberOfComments]);

            return response()->json([
                'status' => 200,
                'status_message' => $status_message,
                'comment' => view('place.comment.view',
                    compact('place', 'comment'))->render(),
                'number_of_comments' => $number_of_comments,
            ]);
        } else {
            return redirect(route('place.show', [
                    'language' => App::getLocale(),
                    'place' => $place->id,
                ]) . '#comment-' . $comment->id)->with('status',
                $status_message);
        }
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
            $status_message = trans('gottashit.comment.deleted_comment',
                ['place' => $place->name]);

            $comment->forceDelete();
        } else {
            $status_message = trans('gottashit.comment.delete_comment_not_allowed',
                ['place' => $place->name]);
        }

        if ($request->ajax()) {
            $number_of_comments = trans_choice('gottashit.comment.comments',
                $place->numberOfComments,
                ['number_of_comments' => $place->numberOfComments]);

            return response()->json([
                'status' => 200,
                'status_message' => $status_message,
                'number_of_comments' => $number_of_comments,
            ]);
        } else {
            return redirect(route('place.show',
                [
                    'language' => App::getLocale(),
                    'place' => $place->id,
                ]))->with('status',
                $status_message);
        }
    }
}
