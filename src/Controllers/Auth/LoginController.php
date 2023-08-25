<?php

namespace Src\Controllers\Auth;

use Src\Controllers\BaseController;
use Src\Helpers\Auth;
use Src\Helpers\Session;

class LoginController extends BaseController
{
    public function index()
    {
        $this->res->renderView("pages.auth.login");
    }

    public function login()
    {
        extract($this->req->getInputs());
        if (Auth::login($email, $password, $this->req->getInputs("is_remember") !== null)) {
            $back_url = $this->req->getInputs("back_url");
            $this->res->redirect(isset($back_url) ? $back_url : "/");
        } else {
            Session::setFlashMessage("alert_error", "Your email or password is incorrect");
            $this->res->reload();
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->res->redirect("/login");
    }
}
