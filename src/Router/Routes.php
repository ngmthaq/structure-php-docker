<?php

namespace Src\Router;

use Src\Controllers\Auth\ChangePasswordController;
use Src\Controllers\Auth\ForgetPasswordController;
use Src\Controllers\Auth\LoginController;
use Src\Controllers\Auth\RegisterController;
use Src\Controllers\Auth\VerifyController;
use Src\Controllers\HomeController;
use Src\Middlewares\AuthMiddleware;
use Src\Middlewares\CorsMiddleware;
use Src\Middlewares\GuestMiddleware;
use Src\Middlewares\ThrottleMiddleware;
use Src\Middlewares\VerifiedMiddleware;
use Src\Middlewares\XsrfMiddleware;
use Src\Validators\ForgetPasswordValidator;
use Src\Validators\LoginValidator;
use Src\Validators\RegisterValidator;
use Src\Validators\ResetPasswordValidator;
use Src\Validators\VerifyValidator;

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

    /**
     * RRegister routes with PUT method
     * 
     * @return void
     */
    public function registerPutRoutes()
    {
        //
    }

    /**
     * RRegister routes with PATCH method
     * 
     * @return void
     */
    public function registerPatchRoutes()
    {
        //
    }

    /**
     * RRegister routes with DELETE method
     * 
     * @return void
     */
    public function registerDeleteRoutes()
    {
        //
    }

    /**
     * RRegister auth routes
     * 
     * @return void
     */
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

        $this->get([
            "path" => "/verify",
            "controller" => VerifyController::class,
            "action" => "index",
            "validator" => VerifyValidator::class,
            "middlewares" => [],
        ]);

        $this->get([
            "path" => "/password/forget",
            "controller" => ForgetPasswordController::class,
            "action" => "forgetPassword",
            "middlewares" => [GuestMiddleware::class],
        ]);

        $this->get([
            "path" => "/password/reset",
            "controller" => ForgetPasswordController::class,
            "action" => "renderResetPasswordView",
            "middlewares" => [GuestMiddleware::class],
        ]);

        $this->get([
            "path" => "/password/change",
            "controller" => ChangePasswordController::class,
            "action" => "index",
            "middlewares" => [AuthMiddleware::class],
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

        $this->post([
            "path" => "/email/resent",
            "controller" => VerifyController::class,
            "action" => "resent",
            "middlewares" => [AuthMiddleware::class],
        ]);

        $this->post([
            "path" => "/password/forget",
            "controller" => ForgetPasswordController::class,
            "action" => "sendMailForgetPassword",
            "validator" => ForgetPasswordValidator::class,
            "middlewares" => [GuestMiddleware::class],
        ]);

        $this->put([
            "path" => "/password/change",
            "controller" => ChangePasswordController::class,
            "action" => "changePassword",
            "middlewares" => [GuestMiddleware::class],
        ]);

        $this->put([
            "path" => "/password/reset",
            "controller" => ForgetPasswordController::class,
            "action" => "resetPassword",
            "validator" => ResetPasswordValidator::class,
            "middlewares" => [GuestMiddleware::class],
        ]);
    }

    /**
     * Register
     * 
     * @return void
     */
    public function register()
    {
        $this->registerAuthRoutes();
        $this->registerGetRoutes();
        $this->registerPostRoutes();
        $this->registerPutRoutes();
        $this->registerPatchRoutes();
        $this->registerDeleteRoutes();
    }
}
