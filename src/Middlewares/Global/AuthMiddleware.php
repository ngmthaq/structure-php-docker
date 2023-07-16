<?php

namespace Src\Middlewares\Global;

use Src\Helpers\Auth;

class AuthMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        $back_url = $this->utils->getFullUrl();
        if (!Auth::check()) {
            $this->utils->redirect("/login", compact("back_url"));
            exit();
        }
    }
}
