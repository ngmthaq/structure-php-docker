<?php

namespace Src\Controllers\Auth;

use Src\Controllers\BaseController;
use Src\Helpers\Auth;
use Src\Helpers\DateTime;
use Src\Helpers\Dev;
use Src\Helpers\Session;
use Src\Models\Token\TokenModel;
use Src\Models\User\UserModel;

class VerifyController extends BaseController
{
    public function index()
    {
        $token_value = $this->req->getParams("token");
        $token_model = new TokenModel();
        $token = $token_model->findOneByToken($token_value);
        $token_model->deleteExpiredTokens();
        if ($token) {
            if ($token->expired_at > time()) {
                $user_model = new UserModel();
                $user = $user_model->findOneByUid($token->user_uid);
                if ($user) {
                    $user->email_verified_at = DateTime::unixTimestamp();
                    $is_updated = $user_model->verifyUser($user);
                    if ($is_updated) {
                        $token_model->delete($token);
                        Session::setFlashMessage("alert_success", "Verify your email successfully");
                        Auth::loginWithUid($user->uid);
                        $this->res->redirect("/");
                    } else {
                        Session::setFlashMessage("alert_error", "Cannot verify your account");
                        $this->res->redirect("/login");
                    }
                } else {
                    Session::setFlashMessage("alert_error", "Cannot verify your account");
                    $this->res->redirect("/login");
                }
            } else {
                Session::setFlashMessage("alert_error", "Your token is expired");
                $this->res->redirect("/login");
            }
        } else {
            Session::setFlashMessage("alert_error", "Cannot verify your account");
            $this->res->redirect("/login");
        }
    }

    public function alert()
    {
        $this->res->renderView("pages.verify");
    }
}
