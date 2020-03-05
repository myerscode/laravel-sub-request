<?php

namespace Myerscode\Laravel\SubRequest;

class HttpVerb
{

    const METHODS = [
        self::GET,
        self::HEAD,
        self::POST,
        self::PUT,
        self::DELETE,
        self::CONNECT,
        self::OPTIONS,
        self::TRACE,
        self::PATCH,
    ];

    /**
     * The GET method requests a representation of the specified resource
     */
    const GET = 'GET';

    /**
     * The HEAD method asks for a response identical to that of a GET request, but without the response body
     */
    const HEAD = 'HEAD';

    /**
     * The POST method is used to submit an entity to the specified resource, often causing a change in state or side effects on the server
     */
    const POST = 'POST';

    /**
     * The PUT method replaces all current representations of the target resource with the request payload
     */
    const PUT = 'PUT';

    /**
     * The DELETE method deletes the specified resource
     */
    const DELETE = 'DELETE';

    /**
     * The CONNECT method establishes a tunnel to the server identified by the target resource
     */
    const CONNECT = 'CONNECT';

    /**
     * The OPTIONS method is used to describe the communication options for the target resource
     */
    const OPTIONS = 'OPTIONS';

    /**
     * The TRACE method performs a message loop-back test along the path to the target resource
     */
    const TRACE = 'TRACE';

    /**
     * The PATCH method is used to apply partial modifications to a resource
     */
    const PATCH = 'PATCH';

}
