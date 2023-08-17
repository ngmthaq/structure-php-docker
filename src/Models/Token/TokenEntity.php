<?php

namespace Src\Models\Token;

use Src\Models\Base\BaseEntity;

class TokenEntity extends BaseEntity
{
    public string $uid;
    public string $user_uid;
    public string $token_type;
    public string $token;
    public int $created_at;
    public int $expired_at;

    public function __construct(array $token = [])
    {
        parent::__construct();
        $this->uid = isset($token["uid"]) ? $token["uid"] : "";
        $this->user_uid = isset($token["user_uid"]) ? $token["user_uid"] : "";
        $this->token_type = isset($token["token_type"]) ? $token["token_type"] : "";
        $this->token = isset($token["token"]) ? $token["token"] : "";
        $this->created_at = isset($token["created_at"]) ? $token["created_at"] : -1;
        $this->expired_at = isset($token["expired_at"]) ? $token["expired_at"] : -1;
    }
}
