<?php

namespace Src\Controllers;

use Src\Helpers\Auth;
use Src\Helpers\Session;

class HomeController extends BaseController
{
    public function index()
    {
        $this->renderView("pages.home");
    }

    public function login()
    {
        $this->renderView("pages.login");
    }

    public function attempt()
    {
        extract($this->inputs);
        if (Auth::login($email, $password, isset($this->inputs["is_remember"]))) {
            $back_url = $this->inputs["back_url"];
            $this->redirect($back_url === "" ? "/" : $back_url);
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
