<?php

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;

class Dispatcher
{

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Request
     */
    private $request;

    public function __construct(Router $router, Request $request)
    {
        $this->router = $router;

        $this->request = $request;
    }

    /**
     * Dispatch a sub request to the Laravel application
     *
     * @param string $method
     * @param string $url
     * @param array $input
     *
     * @return Response
     */
    public function dispatch(string $method, string $url, array $input = [])
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
     * Shortcut for sending a GET sub request
     *
     * @param string $url
     * @param array $input
     *
     * @return Response
     */
    public function get(string $url, array $input = [])
    {
        return $this->dispatch(HttpVerb::GET, $url, $input);
    }

    /**
     * Shortcut for sending a POST sub request
     *
     * @param string $url
     * @param array $input
     *
     * @return Response
     */
    public function post(string $url, array $input = [])
    {
        return $this->dispatch(HttpVerb::POST, $url, $input);
    }

    /**
     * Shortcut for sending a PUT sub request
     *
     * @param string $url
     * @param array $input
     *
     * @return Response
     */
    public function put(string $url, array $input = [])
    {
        return $this->dispatch(HttpVerb::PUT, $url, $input);
    }

    /**
     * Shortcut for sending a DELETE sub request
     *
     * @param string $url
     * @param array $input
     *
     * @return Response
     */
    public function delete(string $url, array $input = [])
    {
        return $this->dispatch(HttpVerb::DELETE, $url, $input);
    }

    /**
     * Shortcut for sending a OPTIONS sub request
     *
     * @param string $url
     * @param array $input
     *
     * @return Response
     */
    public function options(string $url, array $input = [])
    {
        return $this->dispatch(HttpVerb::OPTIONS, $url, $input);
    }

    /**
     * Shortcut for sending a PATCH sub request
     *
     * @param string $url
     * @param array $input
     *
     * @return Response
     */
    public function patch(string $url, array $input = [])
    {
        return $this->dispatch(HttpVerb::PATCH, $url, $input);
    }
}
