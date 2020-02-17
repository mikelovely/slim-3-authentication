<?php

namespace App\Bootstrap;

use Psr\Container\ContainerInterface;

class UtilitiesLoader
{
    public function load(ContainerInterface $container)
    {
        $container['database'] = function () use ($container) {
            $dsn = vsprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', [
                $container['Config']->get('database.mysql.host'),
                $container['Config']->get('database.mysql.port'),
                $container['Config']->get('database.mysql.database'),
            ]);

            $pdo = new \PDO(
                $dsn,
                $container['Config']->get('database.mysql.username'),
                $container['Config']->get('database.mysql.password'),
                [
                    \PDO::ATTR_PERSISTENT => true
                ]
            );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

            return $pdo;
        };
    }
}
