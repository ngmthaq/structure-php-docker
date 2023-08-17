<?php

namespace Src\Controllers\Auth;

use Src\Actions\Dispatch;
use Src\Actions\Events\NewUserRegisteredEvent;
use Src\Controllers\BaseController;
use Src\Helpers\Dev;
use Src\Helpers\Session;
use Src\Helpers\Str;
use Src\Models\User\UserEntity;
use Src\Models\User\UserModel;

class RegisterController extends BaseController
{
    public function index()
    {
        $this->res->renderView("pages.register");
    }

    public function register()
    {
        extract($this->req->getInputs());
        $uid = Str::uuid();
        $user = new UserEntity();
        $user->uid = $uid;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user_model = new UserModel();
        $is_created = $user_model->insert($user);
        if ($is_created) {
            $user = $user_model->findOneByUid($uid);
            Dispatch::event(new NewUserRegisteredEvent($user));
            Session::setFlashMessage("success", "Signup successfully. Please check your email to verify your account");
            $this->res->redirect("/login");
        } else {
            Session::setFlashMessage("error", "Something went wrong. Please try again later");
            $this->res->reload();
        }
    }
}
