<?php

namespace App\Middleware;

use App\Middleware\AbstractMiddleware;

class GuestMiddleware extends AbstractMiddleware
{
    public function __invoke($request, $response, callable $next)
    {
        if ($this->container->get('auth')->check()) {
            return $response->withRedirect($this->container->get('router')->pathFor('home'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
