# Laravel Sub Request

A helper and facade for making internal sub requests to your application API.

[![Latest Stable Version](https://poser.pugx.org/myerscode/laravel-sub-request/v/stable)](https://packagist.org/packages/myerscode/laravel-sub-request)
[![Total Downloads](https://poser.pugx.org/myerscode/laravel-sub-request/downloads)](https://packagist.org/packages/myerscode/laravel-sub-request)
[![PHP Version Require](http://poser.pugx.org/myerscode/laravel-sub-request/require/php)](https://packagist.org/packages/myerscode/laravel-sub-request)
[![License](https://poser.pugx.org/myerscode/laravel-sub-request/license)](https://github.com/myerscode/laravel-sub-request/blob/main/LICENSE)
[![Tests](https://github.com/myerscode/laravel-sub-request/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/myerscode/laravel-sub-request/actions/workflows/tests.yml)
[![codecov](https://codecov.io/gh/myerscode/laravel-sub-request/graph/badge.svg)](https://codecov.io/gh/myerscode/laravel-sub-request)

By sending a sub request within the application, you can consume your application's API without sending separate, slower HTTP requests.

## Requirements

- PHP 8.3+
- Laravel 13.x

## Install

```bash
composer require myerscode/laravel-sub-request
```

The package will be auto-discovered by Laravel.

## Usage

You can inject the `Dispatcher` into your class, use the `SubRequest` facade, or use the global `subrequest` helper.

```php
use Myerscode\Laravel\SubRequest\Dispatcher;
use Myerscode\Laravel\SubRequest\SubRequest;

class MyController
{
    public function __construct(private readonly Dispatcher $subRequest) {}

    // Using dependency injection
    public function withInjection()
    {
        return $this->subRequest->post('/auth', ['foo' => 'bar']);
    }

    // Using the facade
    public function withFacade()
    {
        return SubRequest::dispatch('GET', '/details', ['foo' => 'bar']);
    }

    // Using the helper
    public function withHelper()
    {
        return subrequest('GET', '/details', ['foo' => 'bar']);
    }
}
```

### Available Methods

The `Dispatcher` provides shortcut methods for all HTTP verbs:

```php
$dispatcher->get('/url', $data);
$dispatcher->post('/url', $data);
$dispatcher->put('/url', $data);
$dispatcher->patch('/url', $data);
$dispatcher->delete('/url', $data);
$dispatcher->options('/url', $data);
```

## License

MIT
