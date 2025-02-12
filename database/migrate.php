<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Debug: Print environment variables
echo "Debug: Environment Variables\n";
echo "DB_DRIVER: " . $_ENV['DB_DRIVER'] . "\n";
echo "DB_HOST: " . $_ENV['DB_HOST'] . "\n";
echo "DB_PORT: " . $_ENV['DB_PORT'] . "\n";
echo "DB_DATABASE: " . $_ENV['DB_DATABASE'] . "\n";
echo "DB_USERNAME: " . $_ENV['DB_USERNAME'] . "\n";

try {
    // Initialize the Capsule manager
    $capsule = new Capsule;
    $capsule->addConnection([
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

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    // Include migration files in correct order (handling dependencies)
    require_once __DIR__ . '/migrations/2025_02_10_000003_create_permissions_table.php';  // 1. Permissions first
    require_once __DIR__ . '/migrations/2025_02_10_000004_create_roles_table.php';       // 2. Then Roles
    require_once __DIR__ . '/migrations/2025_02_10_000005_create_role_permissions_table.php'; // 3. Role-Permissions relationship
    require_once __DIR__ . '/migrations/2025_02_10_000006_create_users_table.php';       // 4. Users (depends on roles)
    // require_once __DIR__ . '/migrations/2025_02_10_000000_create_companies_table.php'; // 5. Entreprises
    // require_once __DIR__ . '/migrations/2025_02_10_000002_create_announcements_table.php';    // 6. Annonces (depends on entreprises)

    echo "Migrations run successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
