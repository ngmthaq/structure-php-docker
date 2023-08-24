<?php

namespace Src\Controllers\Auth;

use Src\Actions\Dispatch;
use Src\Actions\Events\SendForgetPasswordMailEvent;
use Src\Controllers\BaseController;
use Src\Helpers\Auth;
use Src\Helpers\Session;
use Src\Models\Token\TokenModel;
use Src\Models\User\UserModel;

class ForgetPasswordController extends BaseController
{
    public const EXPIRED_AFTER = 1 * 24 * 60 * 60; // 1 day

    public function forgetPassword()
    {
        $this->res->renderView("pages.auth.password.forget");
    }

    public function renderResetPasswordView()
    {
        $token_value = $this->req->getParams("token");
        if (empty($token_value)) {
            Session::setFlashMessage("alert_error", "You don't have permission to access this URL");
            $this->res->redirect("/login");
        } else {
            $token_model = new TokenModel();
            $token = $token_model->findOneByToken($token_value);
            $user_model = new UserModel();
            $user = $user_model->findOneByUid($token->user_uid);
            if (empty($user)) {
                Session::setFlashMessage("alert_error", "We cannot verify your account");
                $this->res->redirect("/login");
            } else {
                $this->res->renderView("pages.auth.password.reset");
            }
        }
    }

    public function sendMailForgetPassword()
    {
        $user_model = new UserModel();
        $user = $user_model->findOneByEmail($this->req->getInputs("email"));
        $token_model = new TokenModel();
        $token = $token_model->insert($user, TokenModel::TYPE_FORGET_PASSWORD, time() + self::EXPIRED_AFTER);
        Dispatch::event(new SendForgetPasswordMailEvent($user, $token));
        Session::setFlashMessage("alert_success", "Check email đi");
        $this->res->reload();
    }

    public function resetPassword()
    {
        //
    }
}
