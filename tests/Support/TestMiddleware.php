<?php

declare(strict_types=1);

namespace Tests\Support;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', 'application/json');

        abort(403, 'Access denied');

        return $next($request);
    }
}
