<?php

namespace App\Middleware;

use App\Middleware\AbstractMiddleware;

class AuthMiddleware extends AbstractMiddleware
{
    public function __invoke($request, $response, callable $next)
    {
        if (!$this->container->get('auth')->check()) {
            $this->container->get('flash')->addMessage('error', 'Please sign in before doing that.');
            return $response->withRedirect($this->container->get('router')->pathFor('auth.signin'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
