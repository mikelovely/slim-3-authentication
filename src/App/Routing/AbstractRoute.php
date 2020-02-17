<?php

namespace App\Routing;

use Slim\Container;

abstract class AbstractRoute
{
    protected $container;

    final public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
