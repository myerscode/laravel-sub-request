<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Myerscode\Laravel\SubRequest\HttpVerb;
use Myerscode\Laravel\SubRequest\SubRequest;
use Symfony\Component\HttpFoundation\Response;

if (! function_exists('subrequest')) {

    /**
     * @param  array<mixed>|Collection<string, mixed>  $input
     * @param  array<string, string>  $headers
     * @param  array<string, string>  $cookies
     */
    function subrequest(string $method, string $route, array|Collection $input = [], array $headers = [], array $cookies = []): Response
    {
        if (! in_array($method, HttpVerb::METHODS, true)) {
            throw new InvalidArgumentException('$method must be valid http verb (' . implode(', ', HttpVerb::METHODS) . ')');
        }

        $data = $input instanceof Collection ? $input->toArray() : $input;

        return SubRequest::dispatch($method, $route, $data, $headers, $cookies);
    }
}
