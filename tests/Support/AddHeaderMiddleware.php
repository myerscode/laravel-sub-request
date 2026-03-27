<?php

declare(strict_types=1);

namespace Tests\Support;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddHeaderMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Added-By-Middleware', 'true');

        return $response;
    }
}
