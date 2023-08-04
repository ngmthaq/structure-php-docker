<?php

namespace Src\Middlewares;

use Src\Helpers\Dev;

class CorsMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        if (IS_ENABLE_CORS && $_SERVER["REQUEST_METHOD"] === "OPTIONS") {
            $this->res->sendPreLight();
            exit();
        } else {
            $this->next();
        }
    }
}
