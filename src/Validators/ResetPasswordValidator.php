<?php

namespace Src\Validators;

use Src\Helpers\Str;
use Src\Models\Token\TokenModel;
use Src\Models\User\UserModel;

class ResetPasswordValidator extends BaseValidator
{
    protected function validate(): bool
    {
        $isValidated = true;
        $password = $this->req->getInputs("password");
        $password_confirmation = $this->req->getInputs("password-confirmation");
        $token = $this->req->getInputs("token");

        if (empty($password)) {
            $isValidated = false;
            $this->setMessage("password", "Password is required");
        }

        if (empty($password_confirmation)) {
            $isValidated = false;
            $this->setMessage("password-confirmation", "Password confirmation is required");
        }

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
                    }
                }
            }
        }

        if (isset($password) && isset($password_confirmation) && $password !== $password_confirmation) {
            $isValidated = false;
            $this->setMessage("password-confirmation", "Password confirmation is not match with password");
        }

        return $isValidated;
    }
}
