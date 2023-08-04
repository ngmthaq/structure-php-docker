<?php

namespace Src\Middlewares;

abstract class BaseMiddleware
{
    protected array $params;
    protected array $inputs;
    protected array $files;
    protected mixed $next_function;

    public function __construct(mixed $next_function)
    {
        $this->params               =   $GLOBALS[REQUEST_GLOBAL_KEY]["params"];
        $this->inputs               =   $GLOBALS[REQUEST_GLOBAL_KEY]["inputs"];
        $this->files                =   $GLOBALS[REQUEST_GLOBAL_KEY]["files"];
        $this->next_function        =   $next_function;
    }

    protected function next()
    {
        $next = $this->next_function;
        $next();
    }

    abstract public function handle(): void;
}
