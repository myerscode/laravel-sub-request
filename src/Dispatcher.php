<?php

declare(strict_types=1);

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Symfony\Component\HttpFoundation\Response;

class Dispatcher
{
    public function __construct(private readonly Router $router, private readonly Request $request)
    {
    }

    /**
     * Dispatch a sub request to the Laravel application.
     */
    public function dispatch(string $method, string $url, array $input = []): Response
    {
        $method = strtoupper($method);

        $original = [
            'method' => $this->request->getMethod(),
            'input' => $this->request->input(),
            'route' => $this->router->getCurrentRoute(),
        ];

        $request = $this->request->create($url, $method, $input);

        $this->request->setMethod($method);

        $this->request->replace($request->input());

        $dispatch = $this->router->dispatch($request);

        $this->request->setMethod($original['method']);

        $this->request->replace($original['input']);

        return $dispatch;
    }

    /**
     * Shortcut for sending a GET sub request.
     */
    public function get(string $url, array $input = []): Response
    {
        return $this->dispatch(HttpVerb::GET, $url, $input);
    }

    /**
     * Shortcut for sending a POST sub request.
     */
    public function post(string $url, array $input = []): Response
    {
        return $this->dispatch(HttpVerb::POST, $url, $input);
    }

    /**
     * Shortcut for sending a PUT sub request.
     */
    public function put(string $url, array $input = []): Response
    {
        return $this->dispatch(HttpVerb::PUT, $url, $input);
    }

    /**
     * Shortcut for sending a DELETE sub request.
     */
    public function delete(string $url, array $input = []): Response
    {
        return $this->dispatch(HttpVerb::DELETE, $url, $input);
    }

    /**
     * Shortcut for sending an OPTIONS sub request.
     */
    public function options(string $url, array $input = []): Response
    {
        return $this->dispatch(HttpVerb::OPTIONS, $url, $input);
    }

    /**
     * Shortcut for sending a PATCH sub request.
     */
    public function patch(string $url, array $input = []): Response
    {
        return $this->dispatch(HttpVerb::PATCH, $url, $input);
    }
}
