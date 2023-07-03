<?php

use Dotenv\Dotenv;
use Src\Controllers\BaseController;
use Src\Helpers\Dev;
use Src\Helpers\Dir;
use Src\Helpers\Session;
use Src\Router\Routes;

/**
 * Import composer autoload
 */
require_once("../vendor/autoload.php");


/**
 * Import configs file
 */
require_once("../src/conf.php");

try {
    /**
     * Start session
     */
    Session::start();

    /**
     * Enviroment variables
     */
    $dotenv = Dotenv::createImmutable(Dir::getRootDir());
    $dotenv->load();

    /**
     * Register routes
     */
    $routes = new Routes();
    $routes->register();
    $uri = $routes->getCurrentUri();
    $method = $routes->getCurrentRequestMethod();
    $route = $routes->getRoute($uri, $method);

    if ($route) {
        extract($route);
        $controller_instance = new $controller();
        call_user_func(array($controller_instance, $action));
    } else {
        // 404 Not Found
        $controller_instance = new BaseController();
        $controller_instance->renderView("errors.404", [], STT_NOT_FOUND);
    }
} catch (\Throwable $th) {
    // 500 Server Internal Error
    Dev::console($th->getMessage(), "error");
    $controller_instance = new BaseController();
    $controller_instance->renderView("errors.500", [], STT_INTERNAL_SERVER_ERROR);
}
