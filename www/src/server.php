<?php

use Src\Helpers\Dev;
use Src\Helpers\Session;
use Src\Router\Routes;

/**
 * Import composer autoload
 */
require_once("../vendor/autoload.php");

/**
 * Start session
 */
Session::start();

/**
 * Register routes
 */
$routes = new Routes();
$routes->register();
$route = $routes->getRoute($routes->getCurrentUri(), $routes->getCurrentRequestMethod());

if ($route) {
    extract($route);
    $controller_instance = new $controller();
    $controller_instance->$action();
} else {
    // 404 Not Found
}
