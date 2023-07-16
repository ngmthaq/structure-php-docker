<?php

namespace Src\Controllers;

use Src\Helpers\Auth;
use Src\Helpers\Dev;
use Src\Helpers\Session;
use Src\Middlewares\LoginMiddleware;
use Src\Middlewares\AuthMiddleware;
use Src\Middlewares\GuestMiddleware;

class HomeController extends BaseController
{
    public function index()
    {
        $this->runMiddlewares([AuthMiddleware::class]);
        $this->renderView("pages.home");
    }

    public function login()
    {
        $this->runMiddlewares([GuestMiddleware::class]);
        $this->renderView("pages.login");
    }

    public function attempt()
    {
        $this->runMiddlewares([GuestMiddleware::class, LoginMiddleware::class]);
        extract($this->inputs);
        if (Auth::login($email, $password, isset($this->inputs["is_remember"]))) {
            $this->redirect($this->inputs["back_url"] ?? "/");
        } else {
            Session::setFlashMessage("email", "Email hoặc mật khẩu không chính xác");
            $this->reload();
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect("/login");
    }
}
