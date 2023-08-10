<?php

namespace Src\Middlewares;

use Src\Helpers\Session;

class VerifiedMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        $user = $this->req->getUser();
        if (isset($user) && $user->email_verified_at !== null) {
            $this->next();
        } else {
            Session::setFlashMessage("email_not_verified", "Your email is not verified");
            $this->res->redirect("/login");
        }
    }
}
