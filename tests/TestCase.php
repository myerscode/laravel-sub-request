<?php

namespace Tests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\HttpVerb;
use Orchestra\Testbench\TestCase as Orchestra;
use Tests\Support\TestMiddleware;

class TestCase extends Orchestra
{

    public function setUp(): void
    {
        parent::setUp();

        Route::get('/', function (Request $request) {
            return 'Hello World';
        });

        Route::get('test', function (Request $request) {
            return subrequest('GET', 'apply-middleware', ['hello' => 'world']);
        });

        Route::get('apply-middleware', function (Request $request) {
            return response()->json($request->query->all());
        })->middleware(TestMiddleware::class);

        collect(HttpVerb::METHODS)->each(function ($httpVerb) {
            Route::$httpVerb("/verb/$httpVerb", function (Request $request) use ($httpVerb) {
                return $httpVerb;
            });
        });
    }

    protected function getPackageProviders($app)
    {
        return ['Myerscode\Laravel\SubRequest\SubRequestProvider'];
    }

    public function getDispatcher(): Dispatcher {
        return new Dispatcher($this->app->make('Illuminate\Routing\Router'), $this->app->make('Illuminate\Http\Request'));
    }
}
