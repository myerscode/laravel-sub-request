<?php

use Illuminate\Support\Collection;
use Myerscode\Laravel\SubRequest\HttpVerb;
use Myerscode\Laravel\SubRequest\SubRequest;

if (!function_exists('subrequest')) {

    /**
     * @param $method string HTTP verb to action
     * @param $route string URL of route in the application
     * @param $input array|Collection Data to send
     *
     * @return \Illuminate\Http\Response
     */
    function subrequest(string $method, $route, $input = [])
    {
        if (!in_array($method, HttpVerb::METHODS)) {
            throw new InvalidArgumentException('$method must be valid http verb (' . implode(HttpVerb::METHODS) . ')');
        }

        if ($input instanceof Collection) {
            $data = $input->toArray();
        } elseif (!is_array($data = $input)) {
            throw new InvalidArgumentException('$input must be a an instance of array or \Illuminate\Support\Collection');
        }

        return SubRequest::dispatch($method, $route, $data);
    }
}
