<?php

namespace Src\Models\Queue;

use Src\Models\Base\BaseEntity;

class QueueEntity extends BaseEntity
{
    public string $uid;
    public string $type;
    public string $class;
    public string $method;
    public string $data;
    public int $status;

    public function __construct(array $queue)
    {
        parent::__construct();
        $this->uid = $queue["uid"];
        $this->type = $queue["type"];
        $this->class = $queue["class"];
        $this->method = $queue["method"];
        $this->data = $queue["data"];
        $this->status = $queue["status"];
    }
}
