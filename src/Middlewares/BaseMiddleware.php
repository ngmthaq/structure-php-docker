<?php

namespace Src\Middlewares;

use Src\Controllers\BaseController;

abstract class BaseMiddleware
{
    protected BaseController $utils;

    public function __construct()
    {
        $this->utils = new BaseController();
    }

    abstract public function handle(): void;
}
