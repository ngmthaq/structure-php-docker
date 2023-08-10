<?php

namespace Src\Validators;

use Src\Helpers\Session;
use Src\Middlewares\BaseMiddleware;

abstract class BaseValidator extends BaseMiddleware
{
    abstract protected function validate(): bool;

    public function handle(): void
    {
        if (!$this->validate()) {
            $this->onFailure();
        } else {
            $this->next();
        }
    }

    protected function setMessage(string $key, string $message)
    {
        Session::setFlashMessage($key, $message);
    }

    protected function onFailure(): void
    {
        $this->res->reload();
        exit;
    }
}
