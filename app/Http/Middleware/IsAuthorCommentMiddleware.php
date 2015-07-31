<?php

namespace GottaToShit\Http\Middleware;

use Illuminate\Auth;

use Closure;

class IsAuthorCommentMiddleware
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
        $comment = \GottaToShit\Entities\PlaceComment::Find($request->comment);

        $author_comment_id = $comment->user_id;
        if (\Auth::check()) {
            if (\Auth::User()->id != $author_comment_id) {
                return redirect('/place/' . $request->place);
            }
        }
        else{
            return redirect('/place/' . $request->place);
        }

        return $next($request);
    }
}
