<?php

namespace Src\Middlewares;

class GuestMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        $user = $this->req->getUser();
        if (empty($user)) {
            $this->next();
        } else {
            $this->res->redirect("/");
        }
    }
}
