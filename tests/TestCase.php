<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\HttpVerb;
use Myerscode\Laravel\SubRequest\SubRequestProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Symfony\Component\HttpFoundation\Response;
use Tests\Support\TestMiddleware;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/', fn (Request $request): string => 'Hello World');

        Route::post('/', fn (Request $request): array => $request->request->all());

        Route::get('test', fn (Request $request): Response => subrequest('GET', 'apply-middleware', ['hello' => 'world']));

        Route::get('apply-middleware', fn (Request $request) => response()->json($request->query->all()))->middleware(TestMiddleware::class);

        collect(HttpVerb::METHODS)->each(function (string $httpVerb): void {
            Route::$httpVerb('/verb/' . $httpVerb, fn (Request $request): string => $httpVerb);
        });
    }

    protected function getPackageProviders($app)
    {
        return [SubRequestProvider::class];
    }

    public function getDispatcher(): Dispatcher
    {
        return new Dispatcher($this->app->make(Router::class), $this->app->make(Request::class));
    }
}
