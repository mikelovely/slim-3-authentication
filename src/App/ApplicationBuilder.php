<?php

namespace App;

use App\Bootstrap\ConfigurationLoader;
use App\Bootstrap\ConstantDefinitionLoader;
use App\Bootstrap\RouteLoader;
use App\Bootstrap\ServiceLoader;
use App\Bootstrap\UtilitiesLoader;
use Exception;
use Noodlehaus\Exception\EmptyDirectoryException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\App as SlimApplication;
use Slim\Container;

class ApplicationBuilder
{
    public static function make($options = [])
    {
        $container = new Container(array_merge([
            'settings' => [
                'displayErrorDetails' => true,
            ],
        ], $options));

        $builder = new self();
        $app = $builder->build($container);
        return $app;
    }

    public function build(ContainerInterface $container = null)
    {
        if (!$container) {
            $container = new Container();
        }

        $app = new SlimApplication($container);

        $this->loadConstants();
        $this->loadConfiguration($app->getContainer());
        $this->loadServices($app->getContainer());
        $this->loadUtilities($app->getContainer());
        $this->loadRoutes($app);

        return $app;
    }

    public function loadConstants()
    {
        $loader = new ConstantDefinitionLoader();
        $loader->load();
    }

    private function loadConfiguration(ContainerInterface $container)
    {
        $loader = new ConfigurationLoader();
        $loader->load($container);
    }

    private function loadServices(ContainerInterface $container)
    {
        $loader = new ServiceLoader();
        $loader->load($container);
    }

    private function loadUtilities(ContainerInterface $container)
    {
        $loader = new UtilitiesLoader();
        $loader->load($container);
    }

    private function loadRoutes(SlimApplication $app)
    {
        $loader = new RouteLoader();
        $loader->load($app);
    }
}
