<?php

namespace Src\Middlewares;

use Src\Helpers\Auth;
use Src\Helpers\Session;

class VerifiedMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        $user = $this->req->getUser();
        if (isset($user) && $user->email_verified_at !== null) {
            $this->next();
        } else {
            $this->res->renderView("pages.verify", [], STT_FORBIDDEN);
        }
    }
}
