<?php

namespace Src\Middlewares;

use Src\Helpers\Dev;

class CorsMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        if (IS_ENABLE_CORS) {
            header("Access-Control-Allow-Origin: *");
            if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
                $this->res->sendPreLight();
            } else {
                $this->next();
            }
        } else {
            $this->next();
        }
    }
}
