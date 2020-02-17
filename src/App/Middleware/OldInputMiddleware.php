<?php

namespace App\Middleware;

use App\Middleware\AbstractMiddleware;

class OldInputMiddleware extends AbstractMiddleware
{
    public function __invoke($request, $response, callable $next)
    {
        $this->container->get('view')->getEnvironment()->addGlobal('old', $_SESSION['old']);
        $_SESSION['old'] = $request->getParams();

        $response = $next($request, $response);
        return $response;
    }
}
