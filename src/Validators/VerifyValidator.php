<?php

namespace Src\Validators;

use Src\Helpers\Str;

class VerifyValidator extends BaseValidator
{
    protected function validate(): bool
    {
        $isValidated = true;
        $token = $this->req->getParams("token");

        if (empty($token)) {
            $isValidated = false;
            $this->setMessage("alert_error", "You don't have permission to access this URL");
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
