<?php

namespace GottaToShit\Http\Controllers;

use Illuminate\Http\Request;

use GottaToShit\Http\Requests;
use GottaToShit\Http\Controllers\Controller;

use GottaToShit\Entities\Place;
use GottaToshit\Entities\PlaceStar;

class StarController extends Controller
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
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id_place)
    {
        $this->validate($request, [
          'stars' => 'required|numeric|between:0,5',
        ]);

        $place = Place::findOrFail($id_place);

        $idStar = $place->starForUser()['id'];

        if ($idStar == 0)
        {
            $star = new PlaceStar();

            $star->place_id = $place->id;
            $star->user_id = \Auth::User()->id;
        }
        else
        {
            $star = PlaceStar::findOrFail($idStar);
        }


        $star->stars = $request->input('stars');

        $star->save();

        $status_message = $place->name . ' ' . \Lang::get('gottatoshit.place.rated');
        return redirect('/place/' . $place->id)->with('status', $status_message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
