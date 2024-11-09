<?php

namespace Softexpert\Mercado\utils;

class Auth
{
    private static $auth;
    private static $role;

    public static function getAuth()
    {
        return self::$auth;
    }

    public static function setAuth($token)
    {
        self::$auth = $token;
    }

    public static function getRole()
    {
        return self::$role;
    }

    public static function setRole($role)
    {
        self::$role = $role;
    }
}