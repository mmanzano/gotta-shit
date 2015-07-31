<?php

namespace GottaToShit\Http\Middleware;

use Illuminate\Auth;

use Closure;

class IsAuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $place = \GottaToShit\Entities\Place::Find($request->place);

        $author_id = $place->user_id;
        if (\Auth::check()) {
            if (\Auth::User()->id != $author_id) {
                return redirect('/');
            }
        }
        else{
            return redirect('/');
        }

        return $next($request);
    }
}
