<?php

namespace Src\Validators;

use Src\Helpers\Str;

class LoginValidator extends BaseValidator
{
    protected function validate(): bool
    {
        $isValidated = true;
        $email = $this->req->getInputs("email");
        $password = $this->req->getInputs("password");

        if (!$email) {
            $isValidated = false;
            $this->setMessage("email", "Email is required");
        }

        if ($email && !Str::isEmail($email)) {
            $isValidated = false;
            $this->setMessage("email", "Email is invalid");
        }

        if (!$password) {
            $isValidated = false;
            $this->setMessage("password", "Password is required");
        }

        return $isValidated;
    }
}
