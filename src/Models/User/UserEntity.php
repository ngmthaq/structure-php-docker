<?php

namespace Src\Models\User;

use Src\Models\Base\BaseEntity;

class UserEntity extends BaseEntity
{
    public string $uid;
    public string $name;
    public string $email;
    public string $password;
    public string|null $remember_token;
    public int $created_at;
    public int $updated_at;

    public function __construct(array $user)
    {
        parent::__construct();
        $this->uid = $user["uid"];
        $this->name = $user["name"];
        $this->email = $user["email"];
        $this->password = $user["password"];
        $this->remember_token = $user["remember_token"];
        $this->created_at = $user["created_at"];
        $this->updated_at = $user["updated_at"];
    }
}
