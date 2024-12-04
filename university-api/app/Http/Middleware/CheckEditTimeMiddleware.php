<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class CheckEditTimeMiddleware
{

    public function handle($request, Closure $next)
    {
        // Determine the entity from the route parameters
        $entity = $request->route()->parameter('course') ??
            $request->route()->parameter('module') ??
            $request->route()->parameter('syllabus');

        if ($entity->state->is('published') && $entity->published_at->diffInHours(Carbon::now()) > 6) {
            return response()->json(['message' => 'Editing time has expired. Contact admin.'], 403);
        }

        return $next($request);
    }
}

