<?php

namespace App\Middleware;

abstract class AbstractMiddleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
}
