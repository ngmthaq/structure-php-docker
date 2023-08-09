<?php

namespace Src\Actions\Events;

abstract class BaseEvent
{
    public const CHANNEL_SYNC = "SYNC";

    public const CHANNEL_DATABASE = "DATABASE";

    public mixed $data;

    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    abstract public function listeners(): array;

    public function channel()
    {
        return self::CHANNEL_SYNC;
    }
}
