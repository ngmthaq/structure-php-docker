<?php

namespace Src\Helpers;

use Src\Models\User\UserModel;
use Src\Models\User\UserEntity;

class Auth
{
    public const AUTH_KEY = "AUTH_KEY";

    /**
     * Get auth user
     * 
     * @return UserEntity|null
     */
    public static function user()
    {
        try {
            $user_uid = null;
            $session_key = Session::get(self::AUTH_KEY);
            $cookie_key = Cookies::get(self::AUTH_KEY);
            if (isset($session_key)) {
                $user_uid = $session_key;
            } elseif (isset($cookie_key)) {
                $user_uid = $cookie_key;
            }
            if (empty($user_uid)) return null;
            $user_model = new UserModel();
            $auth_user = $user_model->findOneByUid($user_uid);
            if (!$auth_user) return null;
            return $auth_user;
        } catch (\Throwable $th) {
            Dev::writeLog($th->getMessage(), "error", LOG_STATUS_ERROR);
            return null;
        }
    }

    /**
     * Auth check
     * 
     * @return bool
     */
    public static function check()
    {
        $user = self::user();
        return isset($user);
    }

    /**
     * Login with email and password
     * 
     * @param string $email
     * @param string $password
     * @param bool $is_remember
     * @return bool
     */
    public static function login(string $email, string $password, bool $is_remember = false)
    {
        try {
            $user_model = new UserModel();
            $user = $user_model->findOneByEmail($email);
            if (!$user) return false;
            if (!Hash::check($password, $user->password)) return false;
            if ($is_remember) {
                Cookies::set(self::AUTH_KEY, $user->uid, time() + (86400 * 30));
            } else {
                Cookies::set(self::AUTH_KEY, $user->uid);
            }
            return true;
        } catch (\Throwable $th) {
            Dev::writeLog($th->getMessage(), "error", LOG_STATUS_ERROR);
            return false;
        }
    }

    /**
     * Logout
     * 
     * @return bool
     */
    public static function logout()
    {
        try {
            Cookies::remove(self::AUTH_KEY);
            return true;
        } catch (\Throwable $th) {
            Dev::writeLog($th->getMessage(), "error", LOG_STATUS_ERROR);
            return false;
        }
    }
}
