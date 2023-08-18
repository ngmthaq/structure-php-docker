<?php

namespace Src\Models\Token;

use Src\Helpers\DateTime;
use Src\Helpers\Str;
use Src\Models\Base\BaseModel;
use Src\Models\User\UserEntity;

class TokenModel extends BaseModel
{
    public const TYPE_VERIFY_EMAIL = "TYPE_VERIFY_EMAIL";

    protected TokenDao $token_dao;

    public function __construct()
    {
        parent::__construct();
        $this->token_dao = new TokenDao();
    }

    public function getAll()
    {
        return array_map(function ($token) {
            return new TokenEntity($token);
        }, $this->token_dao->getAll());
    }

    public function findOneByUid(string $uid)
    {
        $token = $this->token_dao->findOneByUid($uid);
        return isset($token) ? new TokenEntity($token) : null;
    }

    public function findOneByToken(string $token_value)
    {
        $token = $this->token_dao->findOneByToken($token_value);
        return isset($token) ? new TokenEntity($token) : null;
    }

    public function insert(UserEntity $user, string $type, int $expired_at)
    {
        $token = new TokenEntity();
        $token->uid = Str::uuid();
        $token->user_uid = $user->uid;
        $token->token_type = $type;
        $token->token = Str::random(64);
        $token->created_at = DateTime::unixTimestamp();
        $token->expired_at = $expired_at;
        if ($this->token_dao->insert($token)) {
            return $token;
        } else {
            return null;
        }
    }
}
