<?php

namespace App\Bootstrap;

use Noodlehaus\Config;
use Psr\Container\ContainerInterface;

class ConfigurationLoader
{
    const ENVIRONMENT_FUNCTIONAL_TESTS = 'functional';

    public function load(ContainerInterface $container)
    {
        $configPath = sprintf("%s/config.json", APP_SOURCE_PATH);
        $container['Config'] = new Config($configPath);
    }
}
