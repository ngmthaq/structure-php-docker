<?php

namespace Src\Models\Queue;

use Src\Models\Base\BaseEntity;

class QueueEntity extends BaseEntity
{
    public string $uid;
    public string $class;
    public string $data;
    public int $status;

    public function __construct(array $queue = [])
    {
        parent::__construct();
        $this->uid = isset($queue["uid"]) ? $queue["uid"] : "";
        $this->class = isset($queue["class"]) ? $queue["class"] : "";
        $this->data = isset($queue["data"]) ? $queue["data"] : "";
        $this->status = isset($queue["status"]) ? $queue["status"] : QUEUE_STATUS_OPEN;
    }
}
