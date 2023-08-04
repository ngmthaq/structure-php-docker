<?php

namespace Src\Middlewares;

use Src\Helpers\Dev;

class CorsMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        $this->next();
    }
}
