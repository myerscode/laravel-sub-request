<?php

declare(strict_types=1);

namespace Myerscode\Laravel\SubRequest;

final class HttpVerb
{
    public const string DELETE = 'DELETE';

    public const string GET = 'GET';

    public const array METHODS = [
        self::GET,
        self::POST,
        self::PUT,
        self::DELETE,
        self::OPTIONS,
        self::PATCH,
    ];

    public const string OPTIONS = 'OPTIONS';

    public const string PATCH = 'PATCH';

    public const string POST = 'POST';

    public const string PUT = 'PUT';
}
