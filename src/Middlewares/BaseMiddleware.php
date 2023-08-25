<?php

namespace Src\Middlewares;

use Src\Helpers\Database;
use Src\Helpers\Request;
use Src\Helpers\Response;
use stdClass;

abstract class BaseMiddleware extends stdClass
{
    protected mixed $next_function;
    protected Request $req;
    protected Response $res;
    protected Database $db;

    public function __construct(mixed $next_function)
    {
        $this->next_function = $next_function;
        $this->req = new Request();
        $this->res = new Response();
        $this->db = $GLOBALS[DATABASE_GLOBAL_KEY];
    }

    /**
     * Handle next function
     * 
     * @return void
     */
    protected function next()
    {
        $next = $this->next_function;
        $next();
    }

    /**
     * Handle middleware logic
     * 
     * @return void
     */
    abstract public function handle(): void;
}
