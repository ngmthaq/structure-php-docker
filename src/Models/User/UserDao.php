<?php

namespace Src\Models\User;

use PDO;
use Src\Helpers\DateTime;
use Src\Helpers\Hash;
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

    public function insert(UserEntity $user): bool
    {
        $sql = "INSERT INTO `users` (`uid`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES (:uid, :name, :email, :password, :created_at, :updated_at)";
        $this->db->setSql($sql);
        $this->db->setParam(":uid", $user->uid);
        $this->db->setParam(":name", $user->name);
        $this->db->setParam(":email", $user->email);
        $this->db->setParam(":password", Hash::make($user->password));
        $this->db->setParam(":created_at", DateTime::unixTimestamp(), PDO::PARAM_INT);
        $this->db->setParam(":updated_at", DateTime::unixTimestamp(), PDO::PARAM_INT);
        $stm = $this->db->execute();
        return isset($stm);
    }

    public function verifyUser(UserEntity $user): bool
    {
        $sql = "UPDATE `users` SET `email_verified_at` = :email_verified_at, `updated_at` = :updated_at WHERE `uid` = :uid";
        $this->db->setSql($sql);
        $this->db->setParam(":email_verified_at", $user->email_verified_at, PDO::PARAM_INT);
        $this->db->setParam(":updated_at", DateTime::unixTimestamp(), PDO::PARAM_INT);
        $this->db->setParam(":uid", $user->uid);
        $stm = $this->db->execute();
        return isset($stm);
    }

    public function changePassword(UserEntity $user): bool
    {
        $sql = "UPDATE `users` SET `password` = :password, `updated_at` = :updated_at WHERE `uid` = :uid";
        $this->db->setSql($sql);
        $this->db->setParam(":password", $user->password);
        $this->db->setParam(":updated_at", DateTime::unixTimestamp(), PDO::PARAM_INT);
        $this->db->setParam(":uid", $user->uid);
        $stm = $this->db->execute();
        return isset($stm);
    }
}
