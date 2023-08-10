<?php

namespace Src\Router;

use Src\Controllers\Auth\LoginController;
use Src\Controllers\Auth\RegisterController;
use Src\Controllers\HomeController;
use Src\Middlewares\AuthMiddleware;
use Src\Middlewares\CorsMiddleware;
use Src\Middlewares\GuestMiddleware;
use Src\Middlewares\ThrottleMiddleware;
use Src\Middlewares\VerifiedMiddleware;
use Src\Middlewares\XsrfMiddleware;
use Src\Validators\LoginValidator;
use Src\Validators\RegisterValidator;

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
    }

    /**
     * RRegister routes with POST method
     * 
     * @return void
     */
    public function registerPostRoutes()
    {
        //
    }

    public function registerAuthRoutes()
    {
        $this->get([
            "path" => "/login",
            "controller" => LoginController::class,
            "action" => "index",
            "middlewares" => [GuestMiddleware::class],
        ]);

        $this->get([
            "path" => "/register",
            "controller" => RegisterController::class,
            "action" => "index",
            "middlewares" => [GuestMiddleware::class],
        ]);

        $this->post([
            "path" => "/login",
            "controller" => LoginController::class,
            "action" => "login",
            "validator" => LoginValidator::class,
            "middlewares" => [GuestMiddleware::class],
        ]);

        $this->post([
            "path" => "/logout",
            "controller" => LoginController::class,
            "action" => "logout",
            "middlewares" => [AuthMiddleware::class],
        ]);

        $this->post([
            "path" => "/register",
            "controller" => RegisterController::class,
            "action" => "register",
            "validator" => RegisterValidator::class,
            "middlewares" => [GuestMiddleware::class],
        ]);
    }

    public function register()
    {
        $this->registerGetRoutes();
        $this->registerPostRoutes();
        $this->registerAuthRoutes();
    }
}
