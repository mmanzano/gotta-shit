<?php

namespace GottaShit\Http\Controllers;

use Illuminate\Http\Request;

use GottaShit\Http\Requests;
use GottaShit\Http\Controllers\Controller;

use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\Place;

Use Illuminate\Support\Facades\App;
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
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $language, $id_place)
    {
        App::setLocale(Session::get('language', $language));

        $this->validate($request, [
          'comment' => 'required',
        ]);

        $place = Place::findOrFail($id_place);

        $comment = new PlaceComment();

        $comment->place_id = $place->id;
        $comment->user_id = \Auth::User()->id;
        $comment->comment = $request->input('comment');

        $comment->save();

        $status_message = trans('gottashit.comment.created_comment', ['place' =>  $place->name]);

        if($request->ajax()){
            $number_of_comments = trans_choice('gottashit.comment.comments', $place->numberOfComments, ['number_of_comments' => $place->numberOfComments]);

            return response()->json([
              'status' => 200,
              'status_message' => $status_message,
              'comment' => view('place.comment.view', compact('place', 'comment'))->render(),
              'number_of_comments' => $number_of_comments,
            ]);
        }
        else{
            return redirect(route('place', ['language' => $language, 'place' => $place->id]) . '#comment-' . $comment->id)->with('status', $status_message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $language, $id_place, $id_comment)
    {
        App::setLocale(Session::get('language', $language));

        $place = Place::findOrFail($id_place);
        $comment = PlaceComment::findOrFail($id_comment);

        return view('place.comment.edit', compact('place', 'comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $language, $id_place, $id_comment)
    {
        App::setLocale(Session::get('language', $language));

        $this->validate($request, [
          'comment' => 'required',
        ]);

        $place = Place::findOrFail($id_place);

        $comment = PlaceComment::findOrFail($id_comment);

        if($comment->isAuthor) {

            $comment->comment = $request->input('comment');

            $comment->save();

            $status_message = trans('gottashit.comment.updated_comment',
              ['place' => $place->name]);
        }
        else {
            $status_message = trans('gottashit.comment.update_comment_not_allowed', ['place' => $place->name]);
        }

        return redirect(route('place', ['language' => $language, 'place' => $place->id]) . '#comment-' . $comment->id)->with('status',
          $status_message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $language, $id_place, $id_comment)
    {
        App::setLocale(Session::get('language', $language));

        $place = Place::findOrFail($id_place);

        $comment = PlaceComment::findOrFail($id_comment);

        if($comment->isAuthor || $place->isAuthor) {
            $status_message = trans('gottashit.comment.deleted_comment', ['place' => $place->name]);

            $comment->forceDelete();
        }
        else {
            $status_message = trans('gottashit.comment.delete_comment_not_allowed', ['place' => $place->name]);

        }

        if ($request->ajax()) {

            $number_of_comments = trans_choice('gottashit.comment.comments', $place->numberOfComments, ['number_of_comments' => $place->numberOfComments]);

            return response()->json([
              'status' => 200,
              'status_message' => $status_message,
              'number_of_comments' => $number_of_comments,
            ]);
        }
        else{
            return redirect(route('place', ['language' => $language, 'place' => $place->id]))->with('status', $status_message);
        }
    }
}
