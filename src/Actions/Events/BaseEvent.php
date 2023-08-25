<?php

namespace Src\Actions\Events;

use stdClass;

abstract class BaseEvent extends stdClass
{
    /**
     * SYNC CHANNEL
     */
    public const CHANNEL_SYNC = "SYNC";

    /**
     * DATABASE_CHANNEL
     */
    public const CHANNEL_DATABASE = "DATABASE";

    /**
     * Event variable
     */
    public stdClass $event;

    public function __construct()
    {
        $this->event = new stdClass();
    }

    /**
     * Register listeners
     * 
     * @return array
     */
    abstract public function listeners(): array;

    /**
     * Setup channel
     * 
     * @return string
     */
    public function channel(): string
    {
        return self::CHANNEL_SYNC;
    }
}
