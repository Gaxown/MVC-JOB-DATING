<?php

namespace App\Core;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    private static $capsule;

    public static function init()
    {
        self::$capsule = new Capsule;

        // $config = require_once '../config/database.php';
        self::$capsule->addConnection([
            'driver'    => $_ENV['DB_DRIVER'],
            'host'      => $_ENV['DB_HOST'],
            'port'      => $_ENV['DB_PORT'],
            'database'  => $_ENV['DB_DATABASE'],
            'username'  => $_ENV['DB_USERNAME'],
            'password'  => $_ENV['DB_PASSWORD'],
            'charset'   => 'utf8',
            'prefix'    => '',
            'schema'    => 'public',
            'sslmode'   => 'disable'
        ]);

        self::$capsule->setAsGlobal();
        self::$capsule->bootEloquent();
    }

    public function getCapsule()
    {
        return self::$capsule;
    }
}
