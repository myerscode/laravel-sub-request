<?php

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

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
}
