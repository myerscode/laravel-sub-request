# Laravel Sub Request
a helper and facade for making internal sub requests to your application API

[![Latest Stable Version](https://poser.pugx.org/myerscode/laravel-sub-request/v/stable)](https://packagist.org/packages/myerscode/laravel-sub-request)
[![Total Downloads](https://poser.pugx.org/myerscode/laravel-sub-request/downloads)](https://packagist.org/packages/myerscode/laravel-sub-request)
[![License](https://poser.pugx.org/myerscode/laravel-sub-request/license)](https://packagist.org/packages/myerscode/laravel-sub-request)

By sending a sub request within the application, you can simply consume your applications API without having to send seperate, slower HTTP requests.

## Install

You can install this package via composer:

``` bash
composer require myerscode/laravel-sub-request
```
## Setup

If using Laravel 5.5 the package will be auto discovered.

If using Laravel 5.4 add `Myerscode\Laravel\SubRequest\SubRequestProvider` to the `providers` array in `config/app.php`

## Usage

In your controller you can inject the sub request component into your class or use the `SubRequest` facade or the global helper method `subrequest`.

```php
namespace App\Controllers;

class MyController {
    
    public function __contstruct(Dispatcher $subRequest) {
        $this->subRequest = $subRequest;
    }
    
    public function routeOne() {
        return $this->subRequest->dispatch('POST', '/auth', ['foo' => 'bar'])
    }
    
    public function routeTwo() {
        return SubRequest::dispatch('GET', '/details', ['foo' => 'bar'])
    }
    
    public function routeThree() {
        return subrequest('GET', '/details', ['foo' => 'bar'])
    }
...
}
```

