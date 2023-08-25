<?php

namespace Src\Actions\Listeners;

use stdClass;

abstract class BaseListener extends stdClass
{
    /**
     * Handle listener logic
     * 
     * @param stdClass $event
     * @return void
     */
    abstract protected function handle(stdClass $event): void;
}
