<?php

namespace GottaShit\Http\Middleware;

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
        $place = \GottaShit\Entities\Place::findOrFail($request->place);
        $comment = \GottaShit\Entities\PlaceComment::findOrFail($request->comment);

        $author_comment_id = $comment->user_id;

        if (\Auth::check()) {
            $user_id = \Auth::User()->id;
            if ($user_id != $author_comment_id) {
                $status_message = trans('gottashit.comment.edit_comment_not_allowed', ['place' =>  $place->name]);

                return redirect('/place/' . $request->place)->with('status', $status_message);
            }
        }
        else{
            return redirect('/place/' . $request->place);
        }

        return $next($request);
    }
}
