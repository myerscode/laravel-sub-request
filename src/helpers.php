<?php

use Myerscode\Laravel\SubRequest\SubRequest;

if (!function_exists('subrequest')) {

    /**
     * @param $method HTTP verb to action
     * @param $route URL of route in the application
     * @param $input Data to send
     *
     * @return \Illuminate\Http\Response
     */
    function subrequest($method, $route, $input)
    {
        return SubRequest::dispatch($method, $route, $input);
    }
}
