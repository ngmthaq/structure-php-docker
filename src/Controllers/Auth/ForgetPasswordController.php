<?php

namespace Src\Controllers\Auth;

use Src\Actions\Dispatch;
use Src\Actions\Events\SendForgetPasswordMailEvent;
use Src\Controllers\BaseController;
use Src\Helpers\Auth;
use Src\Helpers\Dev;
use Src\Helpers\Hash;
use Src\Helpers\Session;
use Src\Models\Token\TokenModel;
use Src\Models\User\UserModel;

class ForgetPasswordController extends BaseController
{
    /**
     * Expired time in unix timestamp
     */
    public const EXPIRED_AFTER = 1 * 24 * 60 * 60; // 1 day

    /**
     * Render forget password view
     * 
     * @return void
     */
    public function forgetPassword(): void
    {
        $this->res->renderView("pages.auth.password.forget");
    }

    /**
     * Render reset password view
     * 
     * @return void
     */
    public function renderResetPasswordView(): void
    {
        $token_value = $this->req->getParams("token");
        if (empty($token_value)) {
            Session::setFlashMessage("alert_error", "You don't have permission to access this URL");
            $this->res->redirect("/login");
        } else {
            $token_model = new TokenModel();
            $token = $token_model->findOneByToken($token_value);
            $token_model->deleteExpiredTokens();
            if (isset($token)) {
                if ($token->expired_at < time()) {
                    $token_model->delete($token);
                    Session::setFlashMessage("alert_error", "We cannot verify your account");
                    $this->res->redirect("/login");
                } else {
                    $user_model = new UserModel();
                    $user = $user_model->findOneByUid($token->user_uid);
                    if (empty($user)) {
                        Session::setFlashMessage("alert_error", "We cannot verify your account");
                        $this->res->redirect("/login");
                    } else {
                        $this->res->renderView("pages.auth.password.reset");
                    }
                }
            } else {
                Session::setFlashMessage("alert_error", "We cannot verify your account");
                $this->res->redirect("/login");
            }
        }
    }

    /**
     * Send email forget password
     * 
     * @return void
     */
    public function sendMailForgetPassword(): void
    {
        $user_model = new UserModel();
        $user = $user_model->findOneByEmail($this->req->getInputs("email"));
        $token_model = new TokenModel();
        $token_model->deleteAllUserTokens($user, TokenModel::TYPE_FORGET_PASSWORD);
        $token = $token_model->insert($user, TokenModel::TYPE_FORGET_PASSWORD, time() + self::EXPIRED_AFTER);
        Dispatch::event(new SendForgetPasswordMailEvent($user, $token));
        Session::setFlashMessage("alert_success", "We have sent a link to reset password in your email");
        $this->res->reload();
    }

    /**
     * Handle reset password
     * 
     * @return void
     */
    public function resetPassword(): void
    {
        $password = $this->req->getInputs("password");
        $token_value = $this->req->getInputs("token");
        $token_model = new TokenModel();
        $token = $token_model->findOneByToken($token_value);
        $user_model = new UserModel();
        $user = $user_model->findOneByUid($token->user_uid);
        $user->password = Hash::make($password);
        $is_updated = $user_model->changePassword($user);
        if ($is_updated) {
            $token_model->delete($token);
            Session::setFlashMessage("alert_success", "Your password was reset successfully");
            $this->res->redirect("/login");
        } else {
            Session::setFlashMessage("alert_error", "Something wrong, please try again later");
            $this->res->redirect("/login");
        }
    }
}
