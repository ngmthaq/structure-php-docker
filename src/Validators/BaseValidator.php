<?php

namespace Src\Validators;

use Src\Helpers\Request;

abstract class BaseValidator
{
    protected Request $req;

    public function __construct(Request $req)
    {
        $this->req = $req;
    }

    abstract protected function validate(): bool;
}
