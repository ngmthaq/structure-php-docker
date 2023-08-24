<?php

namespace Src\Validators;

use Src\Helpers\Str;
use Src\Models\User\UserModel;

class ForgetPasswordValidator extends BaseValidator
{
    protected function validate(): bool
    {
        $isValidated = true;
        $email = $this->req->getInputs("email");

        if (isset($email)) {
            if (Str::isEmail($email)) {
                $user_model = new UserModel();
                $user = $user_model->findOneByEmail($email);
                if (empty($user)) {
                    $isValidated = false;
                    $this->setMessage("email", "Email is not existed in our system");
                }
            } else {
                $isValidated = false;
                $this->setMessage("email", "Email is invalid");
            }
        } else {
            $isValidated = false;
            $this->setMessage("email", "Email is required");
        }

        return $isValidated;
    }
}
