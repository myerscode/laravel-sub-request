<?php

declare(strict_types=1);

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Symfony\Component\HttpFoundation\Response;

class Dispatcher
{
    /** @var array<int, class-string> */
    private array $excludedMiddleware = [];

    public function __construct(private readonly Router $router, private readonly Request $request)
    {
    }

    /**
     * Shortcut for sending a DELETE sub request.
     *
     * @param  array<string, mixed>  $input
     * @param  array<string, string>  $headers
     * @param  array<string, string>  $cookies
     */
    public function delete(string $url, array $input = [], array $headers = [], array $cookies = []): Response
    {
        return $this->dispatch(HttpVerb::DELETE, $url, $input, $headers, $cookies);
    }

    /**
     * Dispatch a sub request to the Laravel application.
     *
     * @param  array<string, mixed>  $input
     * @param  array<string, string>  $headers
     * @param  array<string, string>  $cookies
     */
    public function dispatch(string $method, string $url, array $input = [], array $headers = [], array $cookies = []): Response
    {
        $method = strtoupper($method);

        $originalHeaders = [];
        foreach ($headers as $name => $value) {
            $originalHeaders[$name] = $this->request->headers->get($name);
        }

        $originalCookies = [];
        foreach ($cookies as $name => $value) {
            $originalCookies[$name] = $this->request->cookies->get($name);
        }

        $original = [
            'method' => $this->request->getMethod(),
            'input' => $this->request->input(),
            'route' => $this->router->getCurrentRoute(),
            'headers' => $originalHeaders,
            'cookies' => $originalCookies,
        ];

        $request = $this->request->create($url, $method, $input);

        foreach ($headers as $name => $value) {
            $request->headers->set($name, $value);
            $this->request->headers->set($name, $value);
        }

        foreach ($cookies as $name => $value) {
            $request->cookies->set($name, $value);
            $this->request->cookies->set($name, $value);
        }

        $this->request->setMethod($method);

        $this->request->replace($request->input());

        if ($this->excludedMiddleware !== []) {
            $route = $this->router->getRoutes()->match($request);
            $originalExcluded = $route->excludedMiddleware();
            $route->withoutMiddleware($this->excludedMiddleware);
            $this->excludedMiddleware = [];
        }

        $dispatch = $this->router->dispatch($request);

        if (isset($route, $originalExcluded)) {
            $action = $route->getAction();
            $action['excluded_middleware'] = $originalExcluded;
            $route->setAction($action);
        }

        $this->request->setMethod($original['method']);

        $this->request->replace($original['input']);

        foreach ($original['headers'] as $name => $value) {
            if ($value === null) {
                $this->request->headers->remove($name);
            } else {
                $this->request->headers->set($name, $value);
            }
        }

        foreach ($original['cookies'] as $name => $value) {
            if ($value === null) {
                $this->request->cookies->remove($name);
            } else {
                $this->request->cookies->set($name, $value);
            }
        }

        return $dispatch;
    }

    /**
     * Shortcut for sending a GET sub request.
     *
     * @param  array<string, mixed>  $input
     * @param  array<string, string>  $headers
     * @param  array<string, string>  $cookies
     */
    public function get(string $url, array $input = [], array $headers = [], array $cookies = []): Response
    {
        return $this->dispatch(HttpVerb::GET, $url, $input, $headers, $cookies);
    }

    /**
     * Shortcut for sending an OPTIONS sub request.
     *
     * @param  array<string, mixed>  $input
     * @param  array<string, string>  $headers
     * @param  array<string, string>  $cookies
     */
    public function options(string $url, array $input = [], array $headers = [], array $cookies = []): Response
    {
        return $this->dispatch(HttpVerb::OPTIONS, $url, $input, $headers, $cookies);
    }

    /**
     * Shortcut for sending a PATCH sub request.
     *
     * @param  array<string, mixed>  $input
     * @param  array<string, string>  $headers
     * @param  array<string, string>  $cookies
     */
    public function patch(string $url, array $input = [], array $headers = [], array $cookies = []): Response
    {
        return $this->dispatch(HttpVerb::PATCH, $url, $input, $headers, $cookies);
    }

    /**
     * Shortcut for sending a POST sub request.
     *
     * @param  array<string, mixed>  $input
     * @param  array<string, string>  $headers
     * @param  array<string, string>  $cookies
     */
    public function post(string $url, array $input = [], array $headers = [], array $cookies = []): Response
    {
        return $this->dispatch(HttpVerb::POST, $url, $input, $headers, $cookies);
    }

    /**
     * Shortcut for sending a PUT sub request.
     *
     * @param  array<string, mixed>  $input
     * @param  array<string, string>  $headers
     * @param  array<string, string>  $cookies
     */
    public function put(string $url, array $input = [], array $headers = [], array $cookies = []): Response
    {
        return $this->dispatch(HttpVerb::PUT, $url, $input, $headers, $cookies);
    }

    /**
     * Exclude middleware from the next dispatched sub request.
     *
     * @param  array<int, class-string>|class-string  $middleware
     */
    public function withoutMiddleware(array|string $middleware): static
    {
        $this->excludedMiddleware = array_merge(
            $this->excludedMiddleware,
            (array) $middleware,
        );

        return $this;
    }
}
