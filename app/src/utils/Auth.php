<?php

namespace Softexpert\Mercado\utils;

class Auth
{
    private static $auth;

    public static function getAuth()
    {
        return self::$auth;
    }

    public static function setAuth($token)
    {
        self::$auth = $token;
    }
}