<?php

namespace App\Routing\Home;

use App\Routing\AbstractRoute;

class GetRoutes extends AbstractRoute
{
    public function home($request, $response)
    {
        return $this->container->get('view')->render($response, 'home.twig');
    }
}
