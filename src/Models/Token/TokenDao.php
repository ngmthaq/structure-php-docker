<?php

namespace Src\Models\Token;

use PDO;
use Src\Helpers\DateTime;
use Src\Models\Base\BaseDao;

class TokenDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {
        $this->db->setSql("SELECT * FROM tokens");
        $stm = $this->db->execute();
        return $stm->fetchAll();
    }

    public function findOneByUid(string $uid): array | null
    {
        $this->db->setSql("SELECT * FROM tokens WHERE uid = :uid");
        $this->db->setParam(":uid", $uid, PDO::PARAM_STR);
        $stm = $this->db->execute();
        $token = $stm->fetch();
        if (!$token) return null;
        return $token;
    }

    public function findOneByToken(string $token): array | null
    {
        $this->db->setSql("SELECT * FROM tokens WHERE token = :token");
        $this->db->setParam(":token", $token, PDO::PARAM_STR);
        $stm = $this->db->execute();
        $token = $stm->fetch();
        if (!$token) return null;
        return $token;
    }

    public function insert(TokenEntity $token): bool
    {
        $sql = "INSERT INTO `tokens` (`uid`, `user_uid`, `token_type`, `token `, `created_at`, `expired_at`) VALUES (:uid, :user_uid, :token_type, :token , :created_at, :expired_at)";
        $this->db->setSql($sql);
        $this->db->setParam(":uid", $token->uid);
        $this->db->setParam(":user_uid", $token->user_uid);
        $this->db->setParam(":token_type", $token->token_type);
        $this->db->setParam(":token", $token->token);
        $this->db->setParam(":created_at", DateTime::unixTimestamp());
        $this->db->setParam(":expired_at", $token->expired_at);
        $stm = $this->db->execute();
        return isset($stm);
    }
}
