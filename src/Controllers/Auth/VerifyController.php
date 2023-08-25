<?php

namespace Src\Controllers\Auth;

use Src\Actions\Dispatch;
use Src\Actions\Events\NewUserRegisteredEvent;
use Src\Controllers\BaseController;
use Src\Helpers\Auth;
use Src\Helpers\DateTime;
use Src\Helpers\Session;
use Src\Models\Token\TokenModel;
use Src\Models\User\UserModel;

class VerifyController extends BaseController
{
    /**
     * Handle verify user logic
     * 
     * @return void
     */
    public function index(): void
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
                    if ($user->email_verified_at) {
                        Session::setFlashMessage("alert_error", "Your email has verified before");
                        $this->res->redirect("/login");
                    } else {
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
                    }
                } else {
                    Session::setFlashMessage("alert_error", "Cannot verify your account");
                    $this->res->redirect("/login");
                }
            } else {
                Session::setFlashMessage("alert_error", "Cannot verify your account");
                $this->res->redirect("/login");
            }
        } else {
            Session::setFlashMessage("alert_error", "Cannot verify your account");
            $this->res->redirect("/login");
        }
    }

    /**
     * Handle resent email
     * 
     * @return void
     */
    public function resent(): void
    {
        try {
            $user = Auth::user();
            if ($user->email_verified_at) {
                Session::setFlashMessage("alert_error", "Your email has verified before");
                $this->res->redirect("/");
            } else {
                $token_model = new TokenModel();
                $expired_at = time() + 1 * 24 * 60 * 60;
                $token_model->deleteAllUserTokens($user, TokenModel::TYPE_VERIFY_EMAIL);
                $token = $token_model->insert($user, TokenModel::TYPE_VERIFY_EMAIL, $expired_at);
                if ($token) {
                    Dispatch::event(new NewUserRegisteredEvent($user, $token));
                    Session::setFlashMessage("alert_success", "We have sent a link to your email, please check it");
                } else {
                    Session::setFlashMessage("alert_error", "Something wrong, please try again later");
                }
                $this->res->redirect("/");
            }
        } catch (\Throwable $th) {
            Session::setFlashMessage("alert_error", "Something wrong, please try again later");
            $this->res->redirect("/");
        }
    }
}
