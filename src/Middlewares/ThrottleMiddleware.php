<?php

namespace Src\Middlewares;

use Src\Helpers\Dev;

class ThrottleMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        $this->next();
    }
}
