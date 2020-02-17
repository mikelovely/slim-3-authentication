<?php

namespace App\Bootstrap;

use App\Auth\AuthService;
use App\User\UserService;
use App\Validation\Validator;
use Psr\Container\ContainerInterface;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class ServiceLoader
{
    public function load(ContainerInterface $container)
    {
        $container['user'] = function ($container) {
            return new UserService(
                $container->get('database')
            );
        };

        $container['view'] = function ($container) {
            $view = new Twig(__DIR__ . '/../../../resources/views', [
                'cache' => false,
            ]);

            $view->addExtension(new TwigExtension(
                $container->router,
                $container->request->getUri()
            ));

            $view->getEnvironment()->addGlobal('auth', $container->get('auth'));

            $view->getEnvironment()->addGlobal('flash', $container->get('flash'));

            return $view;
        };

        $container['validator'] = function () {
            return new Validator();
        };

        $container['csrf'] = function () {
            return new Guard();
        };

        $container['flash'] = function () {
            return new Messages();
        };

        $container['auth'] = function ($container) {
            return new AuthService($container->get('user'));
        };
    }
}
