<?php

namespace App\Bootstrap;

use Slim\App as SlimApplication;

class RouteLoader
{
    public function load(SlimApplication $app)
    {
        $app->get('/home', \App\Routing\Home\GetRoutes::class . ':home')->setName('home');

        $app->group('', function () use ($app) {
            $app->get('/auth/signup', \App\Routing\Auth\GetRoutes::class . ':getSignUp')->setName('auth.signup');
            $app->post('/auth/signup', \App\Routing\Auth\PostRoutes::class . ':postSignUp');
            $app->get('/auth/signin', \App\Routing\Auth\GetRoutes::class . ':getSignIn')->setName('auth.signin');
            $app->post('/auth/signin', \App\Routing\Auth\PostRoutes::class . ':postSignIn');
        })->add(new \App\Middleware\GuestMiddleware($app->getContainer()));

        $app->group('', function () use ($app) {
            $app->get('/auth/signout', \App\Routing\Auth\GetRoutes::class . ':getSignOut')->setName('auth.signout');
            $app->get('/auth/password/change', \App\Routing\Password\GetRoutes::class . ':getChangePassword')->setName('auth.password.change');
            $app->post('/auth/password/change', \App\Routing\Password\PostRoutes::class . ':postChangePassword');
        })->add(new \App\Middleware\AuthMiddleware($app->getContainer()));

        $app->add(new \App\Middleware\ValidationErrorsMiddleware($app->getContainer()));
        $app->add(new \App\Middleware\OldInputMiddleware($app->getContainer()));
        $app->add(new \App\Middleware\CsrfViewMiddleware($app->getContainer()));

        $app->add($app->getContainer()->get('csrf'));
    }
}
