<?php

namespace Src\Router;

use Src\Controllers\HomeController;
use Src\Middlewares\AuthMiddleware;
use Src\Middlewares\CorsMiddleware;
use Src\Middlewares\GuestMiddleware;
use Src\Middlewares\ThrottleMiddleware;
use Src\Middlewares\VerifiedMiddleware;
use Src\Middlewares\XsrfMiddleware;
use Src\Validators\LoginValidator;

final class Routes extends Configs
{
    public function registerGlobalMiddlewares()
    {
        return [
            CorsMiddleware::class,
            ThrottleMiddleware::class,
            XsrfMiddleware::class,
        ];
    }

    /**
     * Register routes with GET method
     * 
     * @return void
     */
    public function registerGetRoutes()
    {
        $this->get([
            "path" => "/",
            "controller" => HomeController::class,
            "action" => "index",
            "middlewares" => [
                AuthMiddleware::class,
                VerifiedMiddleware::class,
            ],
        ]);

        $this->get([
            "path" => "/login",
            "controller" => HomeController::class,
            "action" => "login",
            "middlewares" => [GuestMiddleware::class],
        ]);
    }

    /**
     * RRegister routes with POST method
     * 
     * @return void
     */
    public function registerPostRoutes()
    {
        $this->post([
            "path" => "/login",
            "controller" => HomeController::class,
            "action" => "attempt",
            "validator" => LoginValidator::class,
            "middlewares" => [GuestMiddleware::class],
        ]);

        $this->post([
            "path" => "/logout",
            "controller" => HomeController::class,
            "action" => "logout",
            "middlewares" => [AuthMiddleware::class],
        ]);
    }

    public function register()
    {
        $this->registerGetRoutes();
        $this->registerPostRoutes();
    }
}
