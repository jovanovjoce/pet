<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Router;

$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
