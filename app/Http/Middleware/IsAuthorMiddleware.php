<?php

namespace GottaShit\Http\Middleware;

use GottaShit\Entities\Place;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Closure;

class IsAuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $place = Place::findOrFail($request->place);

        $author_id = $place->user_id;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            if ($user_id != $author_id) {
                $status_message = trans('gottashit.place.edit_place_not_allowed',
                    ['place' => $place->name]);

                return redirect(route('home',
                    ['language' => $request->language]))->with('status',
                    $status_message);
            }
        } else {
            $status_message = trans('gottashit.place.edit_place_not_allowed',
                ['place' => $place->name]);

            return redirect(route('home',
                ['language' => $request->language]))->with('status',
                $status_message);
        }

        return $next($request);
    }
}
