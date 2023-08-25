<?php

namespace Src\Validators;

use Src\Helpers\Session;
use Src\Middlewares\BaseMiddleware;

abstract class BaseValidator extends BaseMiddleware
{
    /**
     * Handle validate logic
     * 
     * @return void
     */
    abstract protected function validate(): bool;

    /**
     * Handle validator
     * 
     * @return void
     */
    public function handle(): void
    {
        if (!$this->validate()) {
            $this->onFailure();
        } else {
            $this->next();
        }
    }

    /**
     * Set message
     * 
     * @return void
     */
    protected function setMessage(string $key, string $message)
    {
        Session::setFlashMessage($key, $message);
    }

    /**
     * On failure handle
     * 
     * @return void
     */
    protected function onFailure(): void
    {
        $this->res->reload();
        exit;
    }
}
