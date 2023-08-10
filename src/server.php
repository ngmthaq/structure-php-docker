<?php

use Dotenv\Dotenv;
use Src\Helpers\Database;
use Src\Helpers\Dev;
use Src\Helpers\Dir;
use Src\Helpers\Response;
use Src\Helpers\Session;
use Src\Router\Routes;

require_once("../vendor/autoload.php");
require_once("../src/configs.php");
require_once("../src/helpers.php");

try {
    ob_start();
    Session::start();
    $dotenv = Dotenv::createImmutable(Dir::getRootDir());
    $dotenv->load();
    $GLOBALS[DATABASE_GLOBAL_KEY] = new Database();
    $routes = new Routes();
    $main_function = function () use ($routes) {
        $routes->register();
        $uri = $routes->getCurrentUri();
        $method = $routes->getCurrentRequestMethod();
        $route = $routes->getRoute($uri, $method);
        if ($route) {
            extract($route);
            $controller_instance = new $controller();
            if (isset($validator)) $middlewares[] = $validator;
            if (count($middlewares) > 0) {
                $middleware_instances = [];
                $next = function () use ($controller_instance, $action) {
                    call_user_func(array($controller_instance, $action));
                };
                foreach (array_reverse($middlewares) as $middleware) {
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
            ob_clean();
            $res = new Response();
            $res->renderView("errors.404", [], STT_NOT_FOUND);
        }
    };

    $global_middlewares = $routes->registerGlobalMiddlewares();
    $global_middleware_instances = [];
    $global_next = $main_function;
    foreach (array_reverse($global_middlewares) as $global_middleware) {
        $global_middleware_instance = new $global_middleware($global_next);
        $global_middleware_instances[] = $global_middleware_instance;
        $global_next = function () use ($global_middleware_instance) {
            call_user_func(array($global_middleware_instance, "handle"));
        };
    }
    call_user_func(array(end($global_middleware_instances), "handle"));
} catch (\Throwable $th) {
    ob_clean();
    $res = new Response();
    $res->renderView("errors.500", [], STT_INTERNAL_SERVER_ERROR);
    $log_message = $th->getMessage() . " at line " . $th->getLine() . " in file " . $th->getFile();
    Dev::writeLog($log_message, "error", LOG_STATUS_ERROR);
    Dev::console($log_message, "error");
}
