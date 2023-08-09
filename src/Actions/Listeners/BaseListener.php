<?php

namespace Src\Actions\Listeners;

use stdClass;

abstract class BaseListener extends stdClass
{
    abstract protected function handle(stdClass $event): void;
}
