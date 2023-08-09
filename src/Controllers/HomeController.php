<?php

namespace Src\Controllers;

use Src\Actions\Dispatch;
use Src\Actions\Events\LoginEvent;
use Src\Helpers\Auth;
use Src\Helpers\Dev;
use Src\Helpers\Session;
use Src\Helpers\Str;
use Src\Mails\LoginMail;
use Src\Models\Queue\QueueEntity;

class HomeController extends BaseController
{
    public function index()
    {
        $this->res->renderView("pages.home");
    }

    public function login()
    {
        $this->res->renderView("pages.login");
    }

    public function attempt()
    {
        extract($this->req->getInputs());
        if (Auth::login($email, $password, $this->req->getInputs("is_remember") !== null)) {
            $back_url = $this->req->getInputs("back_url");
            $user = Auth::user();
            Dispatch::event(new LoginEvent($user));
            $this->res->redirect($back_url === "" ? "/" : $back_url);
        } else {
            Session::setFlashMessage("email", "Email hoặc mật khẩu không chính xác");
            $this->res->reload();
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->res->redirect("/login");
    }
}
