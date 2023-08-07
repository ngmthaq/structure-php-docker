<?php

namespace Src\Middlewares;

use Src\Helpers\Str;

class XsrfMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        if (empty($_SESSION[XSRF_KEY])) {
            $_SESSION[XSRF_KEY] = Str::random(255);
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && $this->req->getInputs(XSRF_KEY) !== $_SESSION[XSRF_KEY]) {
            $this->res->renderView("errors.403", [], STT_FORBIDDEN);
            exit();
        }

        $this->next();
    }
}
