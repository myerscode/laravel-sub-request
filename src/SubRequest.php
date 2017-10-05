<?php

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Myerscode\Laravel\SubRequest\Dispatcher
 */
class SubRequest extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SubRequest';
    }
}
