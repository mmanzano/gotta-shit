<?php

namespace GottaShit\Http\Middleware;

use Illuminate\Support\Facades\Auth as Auth;
use Closure;

class IsAuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $place = $request->route('place');

        if (Auth::id() != $place->user_id) {
            $statusMessage = trans('gottashit.place.edit_place_not_allowed', ['place' => $place->name]);

            $homeRoute = route('home', ['language' => $request->language]);

            return redirect($homeRoute)
                ->with('status', $statusMessage);
        }

        return $next($request);
    }
}
