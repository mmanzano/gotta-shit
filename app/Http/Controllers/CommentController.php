<?php

namespace GottaShit\Http\Controllers;

use Illuminate\Http\Request;

use GottaShit\Http\Requests;
use GottaShit\Http\Controllers\Controller;

use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\Place;

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
    public function store(Request $request, $id_place)
    {
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

        return redirect('/place/' . $place->id . '#comment-' . $comment->id)->with('status', $status_message);
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
    public function edit(Request $request, $id_place, $id_comment)
    {
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
    public function update(Request $request, $id_place, $id_comment)
    {
        $this->validate($request, [
          'comment' => 'required',
        ]);

        $place = Place::findOrFail($id_place);

        $comment = PlaceComment::findOrFail($id_comment);

        $comment->comment = $request->input('comment');

        $comment->save();

        $status_message = trans('gottashit.comment.updated_comment', ['place' =>  $place->name]);

        return redirect('/place/' . $place->id . '#comment-' . $comment->id)->with('status', $status_message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id_place, $id_comment)
    {
        $place = Place::findOrFail($id_place);

        $comment = PlaceComment::findOrFail($id_comment);

        $status_message = trans('gottashit.comment.deleted_comment', ['place' =>  $place->name]);

        $comment->delete();

        return redirect('/place/' . $place->id)->with('status', $status_message);
    }
}
