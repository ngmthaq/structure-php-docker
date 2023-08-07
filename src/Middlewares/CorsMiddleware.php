<?php

namespace Src\Middlewares;

use Src\Helpers\Dev;

class CorsMiddleware extends BaseMiddleware
{
    private function registerAllowableOrigins(): array
    {
        return [
            "http://127.0.0.1:5500",
        ];
    }

    public function handle(): void
    {
        $http_origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : null;
        if (isset($http_origin) && in_array($http_origin, $this->registerAllowableOrigins())) {
            header("Access-Control-Allow-Origin: $http_origin");
        }

        if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
            $this->res->sendPreLight();
        } else {
            $this->next();
        }
    }
}
