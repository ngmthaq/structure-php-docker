<?php

namespace Src\Validators;

use Src\Helpers\Str;
use Src\Models\User\UserModel;

class RegisterValidator extends BaseValidator
{
    protected function validate(): bool
    {
        $isValidated = true;
        $email = $this->req->getInputs("email");
        $password = $this->req->getInputs("password");
        $name = $this->req->getInputs("name");

        if (isset($email)) {
            if (Str::isEmail($email)) {
                $user_model = new UserModel();
                $user = $user_model->findOneByEmail($email);
                if (isset($user)) {
                    $isValidated = false;
                    $this->setMessage("email", "Email is existed in our system");
                }
            } else {
                $isValidated = false;
                $this->setMessage("email", "Email is invalid");
            }
        } else {
            $isValidated = false;
            $this->setMessage("email", "Email is required");
        }

        if (!$password) {
            $isValidated = false;
            $this->setMessage("password", "Password is required");
        }

        if (!$name) {
            $isValidated = false;
            $this->setMessage("name", "Name is required");
        }

        return $isValidated;
    }
}
