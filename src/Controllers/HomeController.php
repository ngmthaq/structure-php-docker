<?php

namespace Src\Controllers;

use Src\Helpers\Auth;
use Src\Helpers\Dev;

class HomeController extends BaseController
{
    public function index()
    {
        if (Auth::check()) {
            $this->renderView("pages.home");
        } else {
            $this->redirect("/login");
        }
    }

    public function login()
    {
        if (Auth::check()) {
            $this->redirect("/");
        } else {
            $this->renderView("pages.login");
        }
    }

    public function attempt()
    {
        extract($this->inputs);
        if (Auth::login($email, $password, isset($this->inputs["is_remember"]))) {
            $this->redirect("/");
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
