<?php

declare(strict_types=1);

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Support\Facades\Facade;

/**
 * @see Dispatcher
 */
class SubRequest extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'SubRequest';
    }
}
