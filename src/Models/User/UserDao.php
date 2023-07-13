<?php

namespace Src\Models\User;

use PDO;
use Src\Models\Base\BaseDao;

class UserDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {
        $this->db->setSql("SELECT * FROM users");
        $stm = $this->db->execute();
        $raw_users = $stm->fetchAll();
        return array_map(function ($raw_user) {
            return new UserEntity($raw_user);
        }, $raw_users);
    }

    public function findOneByUid(string $uid): UserEntity | null
    {
        $this->db->setSql("SELECT * FROM users WHERE uid = :uid");
        $this->db->setParam(":uid", $uid, PDO::PARAM_STR);
        $stm = $this->db->execute();
        $raw_user = $stm->fetch();
        if (!$raw_user) return null;
        return new UserEntity($raw_user);
    }
}
