<?php

namespace Src\Middlewares;

class AuthMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        $user = $this->req->getUser();
        if (isset($user)) {
            $this->next();
        } else {
            $this->res->redirect("/login");
        }
    }
}
