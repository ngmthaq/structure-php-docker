<?php

namespace Src\Actions;

use Src\Actions\Events\BaseEvent;
use Src\Helpers\Str;
use Src\Models\Queue\QueueEntity;
use Src\Models\Queue\QueueModel;

final class Dispatch
{
    final public static function event(BaseEvent $event)
    {
        if ($event->channel() === BaseEvent::CHANNEL_SYNC) {
            foreach ($event->listeners() as $listener) {
                $listener_instance = new $listener();
                $listener_instance->handle($event->event);
            }
        } elseif ($event->channel() === BaseEvent::CHANNEL_DATABASE) {
            foreach ($event->listeners() as $listener) {
                $queue = new QueueEntity();
                $queue->uid = Str::uuid();
                $queue->class = $listener;
                $queue->data = json_encode($event->event);
                $queue_model = new QueueModel();
                $queue_model->create($queue);
            }
            shell_exec("php /var/www/html/queue.php > /dev/null 2>&1 &");
        }
    }
}
