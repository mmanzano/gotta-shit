<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\Subscription;
use GottaShit\Entities\User;
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
     * @param Request $request
     * @param AppMailer $mailer
     * @param string $language
     * @param Place $place
     * @return Response
     * @throws \Throwable
     */
    public function store(
        Request $request,
        AppMailer $mailer,
        string $language,
        Place $place
    ) {
        $this->validate($request, [
            'comment' => 'required',
        ]);

        $comment = new PlaceComment();

        $comment->place_id = $place->id;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->input('comment');

        $comment->save();

        $author_of_comment = Auth::user();

        $subscriptions = $place->subscriptions()->getResults();

        $subscription_number = Subscription::where('user_id', Auth::user()->id)
            ->where('place_id', $place->id)
            ->count();

        if (!$subscription_number) {
            $subscription_new = new Subscription();
            $subscription_new->user_id = Auth::user()->id;
            $subscription_new->place_id = $place->id;
            $subscription_new->comment_id = null;
            $subscription_new->save();
        }

        foreach ($subscriptions as $subscription) {
            if ($subscription->user_id == $author_of_comment->id) {
                $subscription->comment_id = null;
                $subscription->save();
            } else {
                if (is_null($subscription->comment_id)) {
                    $subscriber = User::findOrFail($subscription->user_id);
                    $mailer->sendCommentAddNotification(
                        $author_of_comment,
                        $subscriber,
                        $place,
                        $comment,
                        $subscription,
                        trans('gottashit.email.new_comment_add', ['place' => $place->name], $subscriber->language)
                    );
                }
            }
        }

        $status_message = trans('gottashit.comment.created_comment',
            ['place' => $place->name]);

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
                'button_box' => view('place.subscription.remove',
                    compact('place'))->render(),
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
