<?php

namespace Src\Controllers;

use Src\Helpers\Auth;
use Src\Helpers\Session;
use Src\Helpers\Str;
use Src\Mails\LoginMail;
use Src\Models\Queue\QueueEntity;

class HomeController extends BaseController
{
    public function index()
    {
        $queue_array = [];
        $queue_array["uid"] = Str::uuid();
        $queue_array["type"] = QUEUE_TYPE_NORMAL;
        $queue_array["class"] = HomeController::class;
        $queue_array["method"] = "testQueue";
        $queue_array["data"] = json_encode([]);
        $queue_array["status"] = QUEUE_STATUS_OPEN;
        $queue = new QueueEntity($queue_array);
        setupQueue($queue);
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
            $mail = new LoginMail(Auth::user());
            $mail->send();
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

    public function testQueue()
    {
        //
    }
}
