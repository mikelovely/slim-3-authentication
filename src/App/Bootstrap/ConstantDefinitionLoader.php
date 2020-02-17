<?php

namespace App\Bootstrap;

class ConstantDefinitionLoader
{
    public function load()
    {
        if (!defined('APP_SOURCE_PATH')) {
            $sourcePath = substr(realpath(dirname(__FILE__)), 0, -18);
            if (!$sourcePath && !empty($_SERVER['SCRIPT_FILENAME'])) {
                $sourcePath = dirname($_SERVER['SCRIPT_FILENAME']);
            }
            define('APP_SOURCE_PATH', $sourcePath);
        }

        if (!defined('APP_APPLICATION_ENVIRONMENT')) {
            define('APP_APPLICATION_ENVIRONMENT', getenv('APP_APPLICATION_ENVIRONMENT'));
        }

        if (!defined('APP_APPLICATION_ENVIRONMENT')) {
            throw new \Exception('Environment role not set.');
        }
    }
}
