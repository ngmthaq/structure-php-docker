<?php

namespace Src\Middlewares;

use Src\Helpers\Dev;
use Src\Helpers\Session;

class LoginMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        $isValidated = true;

        if (empty($this->utils->inputs["email"])) {
            Session::setFlashMessage("email", "Vui lòng điền email");
            $isValidated = false;
        }

        if (empty($this->utils->inputs["password"])) {
            Session::setFlashMessage("password", "Vui lòng điền mật khẩu");
            $isValidated = false;
        }

        if (!$isValidated) {
            $this->utils->reload();
            exit();
        }
    }
}
