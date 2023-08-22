<?php

namespace Src\Controllers\Auth;

use Src\Controllers\BaseController;

class ForgetPasswordController extends BaseController
{
    public function forgetPassword()
    {
        $this->res->renderView("pages.auth.password.forget");
    }

    public function resetPassword()
    {
        //
    }

    public function sendMailForgetPassword()
    {
        //
    }

    public function changePassword()
    {
        //
    }
}
