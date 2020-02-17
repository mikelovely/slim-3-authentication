<?php

namespace App\Routing\Password;

use App\Routing\AbstractRoute;

class GetRoutes extends AbstractRoute
{
    public function getChangePassword($request, $response)
    {
        return $this->container->get('view')->render($response, 'auth/password/change.twig');
    }
}
