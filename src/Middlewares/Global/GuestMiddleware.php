<?php

namespace Src\Middlewares\Global;

use Src\Helpers\Auth;

class GuestMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        if (Auth::check()) {
            $this->utils->redirect("/");
            exit();
        }
    }
}
