<?php

namespace App\Middleware;

use App\Middleware\AbstractMiddleware;

class CsrfViewMiddleware extends AbstractMiddleware
{
    public function __invoke($request, $response, callable $next)
    {
        $this->container->get('view')->getEnvironment()->addGlobal('csrf', [
            'field' => '
                <input type="hidden" name="' . $this->container->get('csrf')->getTokenNameKey() . '" value="' . $this->container->get('csrf')->getTokenName() . '">
                <input type="hidden" name="' . $this->container->get('csrf')->getTokenValueKey() . '" value="' . $this->container->get('csrf')->getTokenValue() . '">
            ',
        ]);

        $response = $next($request, $response);
        return $response;
    }
}
