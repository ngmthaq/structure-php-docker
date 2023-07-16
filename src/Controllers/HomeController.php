<?php

namespace Src\Controllers;

use Src\Helpers\Auth;
use Src\Helpers\Dev;
use Src\Middlewares\Global\AuthMiddleware;
use Src\Middlewares\Global\GuestMiddleware;

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
        extract($this->inputs);
        if (Auth::login($email, $password, isset($this->inputs["is_remember"]))) {
            $this->redirect($this->inputs["back_url"] ?? "/");
        } else {
            $this->reload();
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect("/login");
    }
}
