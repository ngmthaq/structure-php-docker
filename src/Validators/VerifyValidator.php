<?php

namespace Src\Validators;

use Src\Helpers\Str;
use Src\Models\Token\TokenModel;
use Src\Models\User\UserModel;

class VerifyValidator extends BaseValidator
{
    protected function validate(): bool
    {
        $isValidated = true;
        $token = $this->req->getParams("token");

        if (empty($token)) {
            $isValidated = false;
            $this->setMessage("alert_error", "You don't have permission to access this URL");
        } else {
            $token_model = new TokenModel();
            $token_entity = $token_model->findOneByToken($token);
            if (empty($token_entity)) {
                $isValidated = false;
                $this->setMessage("alert_error", "We cannot verify your account");
            } else {
                if ($token_entity->expired_at < time()) {
                    $isValidated = false;
                    $this->setMessage("alert_error", "Your token is expired");
                    $token_model->delete($token_entity);
                } else {
                    $user_model = new UserModel();
                    $user = $user_model->findOneByUid($token_entity->user_uid);
                    if (empty($user)) {
                        $isValidated = false;
                        $this->setMessage("alert_error", "We cannot verify your account");
                        $token_model->delete($token_entity);
                    } else {
                        if ($user->email_verified_at) {
                            $this->setMessage("alert_error", "Your email has verified before");
                            $this->res->redirect("/login");
                        }
                    }
                }
            }
        }

        return $isValidated;
    }

    protected function onFailure(): void
    {
        if ($this->req->getUser()) {
            $this->res->redirect("/");
        } else {
            $this->res->redirect("/login");
        }
    }
}
