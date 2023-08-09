<?php

namespace Src\Actions\Events;

use stdClass;

abstract class BaseEvent extends stdClass
{
    public const CHANNEL_SYNC = "SYNC";

    public const CHANNEL_DATABASE = "DATABASE";

    public stdClass $event;

    public function __construct()
    {
        $this->event = new stdClass();
    }

    abstract public function listeners(): array;

    public function channel()
    {
        return self::CHANNEL_SYNC;
    }
}
