<?php

namespace GottaShit\Http\Controllers;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\Subscription;
use GottaShit\Entities\User;
use GottaShit\Http\Requests;
use GottaShit\Http\Controllers\Controller;
use GottaShit\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @param \GottaShit\Mailers\AppMailer $mailer
     * @param $language
     * @param $id_place
     * @return \GottaShit\Http\Controllers\Response
     */
    public function store(
        Request $request,
        AppMailer $mailer,
        $language,
        $id_place
    ) {
        $this->setLanguage($language);

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $place = Place::findOrFail($id_place);

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
                    $this->setLanguageUser($subscriber);
                    $mailer->sendCommentAddNotification($author_of_comment,
                        $subscriber, $place, $comment, $subscription,
                        trans('gottashit.email.new_comment_add',
                            ['place' => $place->name]));
                }
            }
        }

        $this->setLanguage($language);

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
                    'language' => $language,
                    'place' => $place->id
                ]) . '#comment-' . $comment->id)->with('status',
                $status_message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request, $language, $id_place, $id_comment)
    {
        $this->setLanguage($language);

        $place = Place::findOrFail($id_place);
        $comment = PlaceComment::findOrFail($id_comment);

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
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $language, $id_place, $id_comment)
    {
        $this->setLanguage($language);

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $place = Place::findOrFail($id_place);

        $comment = PlaceComment::findOrFail($id_comment);

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
                    'language' => $language,
                    'place' => $place->id
                ]) . '#comment-' . $comment->id)->with('status',
                $status_message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $language, $id_place, $id_comment)
    {
        $this->setLanguage($language);

        $place = Place::findOrFail($id_place);

        $comment = PlaceComment::findOrFail($id_comment);

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
                    'language' => $language,
                    'place' => $place->id
                ]))->with('status',
                $status_message);
        }
    }
}
