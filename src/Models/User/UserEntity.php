<?php

namespace Src\Models\User;

use Src\Models\Base\BaseEntity;

class UserEntity extends BaseEntity
{
    public string $uid;
    public string $name;
    public string $email;
    public string $password;
    public int|null $email_verified_at;
    public int $created_at;
    public int $updated_at;
    public int|null $deleted_at;

    public function __construct(array $user = [])
    {
        parent::__construct();
        $this->uid = isset($user["uid"]) ? $user["uid"] : "";
        $this->name = isset($user["name"]) ? $user["name"] : "";
        $this->email = isset($user["email"]) ? $user["email"] : "";
        $this->password = isset($user["password"]) ? $user["password"] : "";
        $this->email_verified_at = isset($user["email_verified_at"]) ? $user["email_verified_at"] : null;
        $this->created_at = isset($user["created_at"]) ? $user["created_at"] : -1;
        $this->updated_at = isset($user["updated_at"]) ? $user["updated_at"] : -1;
        $this->deleted_at = isset($user["deleted_at"]) ? $user["deleted_at"] : null;
    }
}
