<?php

namespace GottaShit\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth as Auth;

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

        if (Auth::id() != $comment->user_id) {
            $statusMessage = trans(
                'gottashit.comment.edit_comment_not_allowed',
                ['place' => $place->name]
            );

            $placeRoute = route('place.show', [
                'language' => $request->language,
                'place' => $request->place,
            ]);

            return redirect($placeRoute)
                ->with('status', $statusMessage);
        }

        return $next($request);
    }
}
