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
        return $stm->fetchAll();
    }

    public function findOneByUid(string $uid): array | null
    {
        $this->db->setSql("SELECT * FROM users WHERE uid = :uid");
        $this->db->setParam(":uid", $uid, PDO::PARAM_STR);
        $stm = $this->db->execute();
        $raw_user = $stm->fetch();
        if (!$raw_user) return null;
        return $raw_user;
    }

    public function findOneByEmail(string $email): array | null
    {
        $this->db->setSql("SELECT * FROM users WHERE email = :email");
        $this->db->setParam(":email", $email, PDO::PARAM_STR);
        $stm = $this->db->execute();
        $raw_user = $stm->fetch();
        if (!$raw_user) return null;
        return $raw_user;
    }
}
