<?php

namespace Src\Controllers\Auth;

use Src\Actions\Dispatch;
use Src\Actions\Events\NewUserRegisteredEvent;
use Src\Controllers\BaseController;
use Src\Helpers\Auth;
use Src\Helpers\Dev;
use Src\Helpers\Session;
use Src\Helpers\Str;
use Src\Models\Token\TokenModel;
use Src\Models\User\UserEntity;
use Src\Models\User\UserModel;

class RegisterController extends BaseController
{
    public function index()
    {
        $this->res->renderView("pages.auth.register");
    }

    public function register()
    {
        $this->db->begin();
        try {
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
                $token_model = new TokenModel();
                $expired_at = time() + 1 * 24 * 60 * 60;
                $token = $token_model->insert($user, TokenModel::TYPE_VERIFY_EMAIL, $expired_at);
                if ($token) {
                    Dispatch::event(new NewUserRegisteredEvent($user, $token));
                    Session::setFlashMessage("alert_success", "Signup successfully. Please check your email to verify your account");
                    Auth::loginWithUid($user->uid);
                    $this->db->commit();
                    $this->res->redirect("/");
                } else {
                    $this->db->rollBack();
                    Session::setFlashMessage("alert_error", "Something went wrong. Please try again later");
                    $this->res->reload();
                }
            } else {
                $this->db->rollBack();
                Session::setFlashMessage("alert_error", "Something went wrong. Please try again later");
                $this->res->reload();
            }
        } catch (\Throwable $th) {
            $this->db->rollBack();
            Session::setFlashMessage("alert_error", "Something went wrong. Please try again later");
            $this->res->reload();
        }
    }
}
