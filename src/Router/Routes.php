<?php

namespace Src\Router;

use Src\Controllers\HomeController;
use Src\Middlewares\CorsMiddleware;
use Src\Middlewares\ThrottleMiddleware;

final class Routes extends Configs
{
    public function registerGlobalMiddlewares()
    {
        return [
            CorsMiddleware::class,
            ThrottleMiddleware::class,
        ];
    }

    /**
     * Register routes with GET method
     * 
     * @return void
     */
    public function registerGetRoutes()
    {
        $this->get(["path" => "/", "controller" => HomeController::class, "action" => "index"]);
        $this->get(["path" => "/login", "controller" => HomeController::class, "action" => "login"]);
    }

    /**
     * RRegister routes with POST method
     * 
     * @return void
     */
    public function registerPostRoutes()
    {
        $this->post(["path" => "/login", "controller" => HomeController::class, "action" => "attempt"]);
        $this->post(["path" => "/logout", "controller" => HomeController::class, "action" => "logout"]);
    }

    public function register()
    {
        $this->registerGetRoutes();
        $this->registerPostRoutes();
    }
}
