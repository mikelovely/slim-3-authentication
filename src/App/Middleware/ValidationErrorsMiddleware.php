<?php

namespace App\Middleware;

use App\Middleware\AbstractMiddleware;

class ValidationErrorsMiddleware extends AbstractMiddleware
{
    public function __invoke($request, $response, callable $next)
    {
        $this->container->get('view')->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
        unset($_SESSION['errors']);

        $response = $next($request, $response);
        return $response;
    }
}
