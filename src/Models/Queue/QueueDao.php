<?php

namespace Src\Models\Queue;

use PDO;
use Src\Models\Base\BaseDao;

class QueueDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFirst()
    {
        $this->db->setSql("SELECT * FROM `queue_jobs` LIMIT 1");
        $stm = $this->db->execute();
        return $stm->fetch();
    }

    public function setInProgress(string $uid)
    {
        $this->db->setSql("UPDATE `queue_jobs` SET `status` = :status WHERE `uid` = :uid");
        $this->db->setParam(":status", QUEUE_STATUS_IN_PROGRESS, PDO::PARAM_INT);
        $this->db->setParam(":uid", $uid);
        return $this->db->execute();
    }

    public function setDone(string $uid)
    {
        $this->db->setSql("DELETE FROM `queue_jobs` WHERE `uid` = :uid");
        $this->db->setParam(":uid", $uid);
        return $this->db->execute();
    }

    public function create(QueueEntity $entity)
    {
        $this->db->setSql("INSERT INTO `queue_jobs` (`uid`, `type`, `class`, `method`, `data`) VALUES (:uid, :type, :class, :method, :data)");
        $this->db->setParam(":uid", $entity->uid);
        $this->db->setParam(":type", $entity->type);
        $this->db->setParam(":class", $entity->class);
        $this->db->setParam(":method", $entity->method);
        $this->db->setParam(":data", $entity->data);
        return $this->db->execute();
    }
}
