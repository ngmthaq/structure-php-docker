<?php

namespace Src\Actions;

use Src\Actions\Events\BaseEvent;

class Dispatch
{
    public static function event(BaseEvent $event)
    {
        if ($event->channel() === BaseEvent::CHANNEL_SYNC) {
            foreach ($event->listeners() as $listener) {
                $listener_instance = new $listener($event->data);
                $listener_instance->handle();
            }
        } elseif ($event->channel() === BaseEvent::CHANNEL_DATABASE) {
            //
        }
    }
}
