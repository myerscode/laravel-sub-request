<?php

namespace Tests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Tests\Support\TestMiddleware;

class TestCase extends Orchestra
{

    public function setUp(): void
    {
        parent::setUp();

        Route::group([], function () {
            Route::get('test', function (Request $request) {
                return subrequest('GET', 'apply-middleware', ['hello' => 'world']);
            });

            Route::get('apply-middleware', function (Request $request) {
                return response()->json($request->query->all());
            })->middleware(TestMiddleware::class);
        });

    }

    protected function getPackageProviders($app)
    {
        return ['Myerscode\Laravel\SubRequest\SubRequestProvider'];
    }

}
