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
    ob_start();

    /**
     * Start session
     */
    Session::start();

    /**
     * Environment variables
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
        $global_middlewares = $routes->registerGlobalMiddlewares();
        $middlewares = array_merge($global_middlewares, $middlewares);
        if ($count_middlewares = count($middlewares) > 0) {
            $middleware_instances = [];
            $next = function () use ($controller_instance, $action) {
                call_user_func(array($controller_instance, $action));
            };
            foreach (array_reverse($middlewares) as $key => $middleware) {
                $middleware_instance = new $middleware($next);
                $middleware_instances[] = $middleware_instance;
                $next = function () use ($middleware_instance) {
                    call_user_func(array($middleware_instance, "handle"));
                };
            }
            call_user_func(array(end($middleware_instances), "handle"));
        } else {
            call_user_func(array($controller_instance, $action));
        }
    } else {
        // 404 Not Found
        ob_clean();
        $controller_instance = new BaseController();
        $controller_instance->renderView("errors.404", [], STT_NOT_FOUND);
    }
} catch (\Throwable $th) {
    // 500 Server Internal Error
    ob_clean();
    $controller_instance = new BaseController();
    $controller_instance->renderView("errors.500", [], STT_INTERNAL_SERVER_ERROR);
    $log_message = $th->getMessage() . " at line " . $th->getLine() . " in file " . $th->getFile();
    Dev::writeLog($log_message, "error", LOG_STATUS_ERROR);
    Dev::console($log_message, "error");
}
