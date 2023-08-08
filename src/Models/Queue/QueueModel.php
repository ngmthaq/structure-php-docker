<?php

namespace Src\Models\Queue;

use Src\Models\Base\BaseModel;

class QueueModel extends BaseModel
{
    protected QueueDao $queue_dao;

    public function __construct()
    {
        parent::__construct();
        $this->queue_dao = new QueueDao();
    }

    public function getFirst()
    {
        return new QueueEntity($this->queue_dao->getFirst());
    }

    public function setInProgress(string $uid)
    {
        $output = $this->queue_dao->setInProgress($uid);
        return isset($output);
    }

    public function setDone(string $uid)
    {
        $output = $this->queue_dao->setDone($uid);
        return isset($output);
    }

    public function create(QueueEntity $entity)
    {
        $output = $this->queue_dao->create($entity);
        return isset($output);
    }
}
