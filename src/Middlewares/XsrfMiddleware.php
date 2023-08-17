<?php

namespace Src\Middlewares;

use Src\Helpers\Str;

class XsrfMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        if (empty($_SESSION[XSRF_KEY])) {
            $_SESSION[XSRF_KEY] = Str::random(32);
        }

        $methods = ["POST", "PUT", "PATCH", "DELETE"];
        if (isset($_SERVER["REQUEST_METHOD"]) && in_array($_SERVER["REQUEST_METHOD"], $methods) && $this->req->getInputs(XSRF_KEY) !== $_SESSION[XSRF_KEY]) {
            $this->res->renderView("errors.403", [], STT_FORBIDDEN);
            exit();
        }

        $this->next();
    }
}
