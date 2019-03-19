<?php

namespace GottaShit\Http\Middleware;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Closure;

class IsAuthorCommentMiddleware
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
        $comment = $request->route('comment');

        $author_comment_id = $comment->user_id;

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            if ($user_id != $author_comment_id) {
                $status_message = trans('gottashit.comment.edit_comment_not_allowed',
                    ['place' => $place->name]);

                return redirect(route('place.show', [
                    'language' => $request->language,
                    'place' => $request->place
                ]))->with('status', $status_message);
            }
        } else {
            $status_message = trans('gottashit.comment.edit_comment_not_allowed',
                ['place' => $place->name]);

            return redirect(route('place.show', [
                'language' => $request->language,
                'place' => $request->place
            ]))->with('status', $status_message);
        }

        return $next($request);
    }
}
