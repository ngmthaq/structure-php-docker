<?php

namespace Src\Models\User;

use Src\Models\Base\BaseModel;

class UserModel extends BaseModel
{
    protected UserDao $user_dao;

    public function __construct()
    {
        parent::__construct();
        $this->user_dao = new UserDao();
    }

    public function getAll()
    {
        return array_map(function ($raw_user) {
            return new UserEntity($raw_user);
        }, $this->user_dao->getAll());
    }

    public function findOneByUid(string $uid)
    {
        $user = $this->user_dao->findOneByUid($uid);
        return isset($user) ? new UserEntity($user) : null;
    }

    public function findOneByEmail(string $email)
    {
        $user = $this->user_dao->findOneByEmail($email);
        return isset($user) ? new UserEntity($user) : null;
    }

    public function insert(UserEntity $user)
    {
        return $this->user_dao->insert($user);
    }

    public function verifyUser(UserEntity $user)
    {
        return $this->user_dao->verifyUser($user);
    }
}
