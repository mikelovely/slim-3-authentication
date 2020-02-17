<?php

namespace App\Routing\Auth;

use App\Routing\AbstractRoute;

class GetRoutes extends AbstractRoute
{
    public function getSignIn($request, $response)
    {
        return $this->container->get('view')->render($response, 'auth/signin.twig');
    }

    public function getSignUp($request, $response)
    {
        return $this->container->get('view')->render($response, 'auth/signup.twig');
    }

    public function getSignOut($request, $response)
    {
        $this->container->get('auth')->logout();

        return $response->withRedirect($this->container->get('router')->pathFor('home'));
    }
}
