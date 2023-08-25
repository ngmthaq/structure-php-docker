<?php

namespace Src\Helpers;

use Src\Models\User\UserModel;
use Src\Models\User\UserEntity;

final class Auth
{
    /**
     * Get auth user
     * 
     * @return UserEntity|null
     */
    public static function user(): UserEntity|null
    {
        try {
            $auth = null;
            $session_key = Session::get(AUTH_KEY);
            $cookie_key = Cookies::get(AUTH_KEY);
            if (isset($session_key)) {
                $auth = $session_key;
            } elseif (isset($cookie_key)) {
                $auth = $cookie_key;
            } elseif (isset($GLOBALS[AUTH_KEY])) {
                $auth = $GLOBALS[AUTH_KEY];
            }
            if (empty($auth)) return null;
            $auth = json_decode($auth, true);
            $user_uid = Hash::rowFenceDecrypt($auth["output"], $auth["key"]);
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
    public static function check(): bool
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
    public static function login(string $email, string $password, bool $is_remember = false): bool
    {
        try {
            $user_model = new UserModel();
            $user = $user_model->findOneByEmail($email);
            if (!$user) return false;
            if (!Hash::check($password, $user->password)) return false;
            $hash_key = random_int(2, 16);
            $auth = Hash::rowFenceEncrypt($user->uid, $hash_key);
            $json = json_encode($auth);
            if ($is_remember) {
                Cookies::set(AUTH_KEY, $json, time() + (86400 * 30));
            } else {
                Cookies::set(AUTH_KEY, $json);
            }
            $GLOBALS[AUTH_KEY] = $json;
            return true;
        } catch (\Throwable $th) {
            Dev::writeLog($th->getMessage(), "error", LOG_STATUS_ERROR);
            return false;
        }
    }

    /**
     * Login with user uid
     * 
     * @param string $uid
     * @param bool $is_remember
     * @return bool
     */
    public static function loginWithUid(string $uid, bool $is_remember = false): bool
    {
        $hash_key = random_int(2, 16);
        $auth = Hash::rowFenceEncrypt($uid, $hash_key);
        $json = json_encode($auth);
        if ($is_remember) {
            Cookies::set(AUTH_KEY, $json, time() + (86400 * 30));
        } else {
            Cookies::set(AUTH_KEY, $json);
        }
        $GLOBALS[AUTH_KEY] = $json;
        return true;
    }

    /**
     * Logout
     * 
     * @return bool
     */
    public static function logout(): bool
    {
        try {
            Cookies::remove(AUTH_KEY);
            return true;
        } catch (\Throwable $th) {
            Dev::writeLog($th->getMessage(), "error", LOG_STATUS_ERROR);
            return false;
        }
    }
}
