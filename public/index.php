<?php
require "../vendor/larapack/dd/src/helper.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Core\Database;
use App\Core\Session;
use Dotenv\Dotenv;

include '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

Session::start();
Database::init();

include_once '../config/routes.php';
