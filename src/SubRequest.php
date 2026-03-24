<?php

declare(strict_types=1);

namespace Myerscode\Laravel\SubRequest;

use Illuminate\Support\Facades\Facade;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method static Response dispatch(string $method, string $url, array<string, mixed> $input = [])
 *
 * @see Dispatcher
 */
class SubRequest extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'SubRequest';
    }
}
