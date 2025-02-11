<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create a new Capsule instance
$capsule = new Capsule;

try {
    // Add connection
    $capsule->addConnection([
        'driver'    => getenv('DB_DRIVER'),
        'host'      => getenv('DB_HOST'),
        'port'      => getenv('DB_PORT') ?: '5432',
        'database'  => getenv('DB_DATABASE'),
        'username'  => getenv('DB_USERNAME'),
        'password'  => getenv('DB_PASSWORD'),
        'charset'   => 'utf8',
        'schema'    => 'public',
        'prefix'    => '',
    ]);

    // Make this Capsule instance available globally
    $capsule->setAsGlobal();

    // Setup the Eloquent ORM
    $capsule->bootEloquent();

    // Test the connection
    $result = Capsule::connection()->getPdo();
    echo "Database connection successful!\n";
    echo "Connected to database: " . getenv('DB_DATABASE') . "\n";
    echo "Using driver: " . getenv('DB_DRIVER') . "\n";
} catch (Exception $e) {
    echo "Connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
}
