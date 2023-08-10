<?php

namespace Src\Controllers\Auth;

use Src\Controllers\BaseController;
use Src\Helpers\Dev;

class RegisterController extends BaseController
{
    public function index()
    {
        $this->res->renderView("pages.register");
    }

    public function register()
    {
        //
    }
}
