<?php

namespace Softexpert\Mercado\core;

use Exception;
use PDO;

abstract class Connect
{
    public static $con;

    private const OPTIONS = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    public static function getInstance(): PDO
    {
        if (empty(self::$con)) {
            try {
                self::$con = new PDO($_ENV["DB_DRIVER"].":host=".$_ENV["DB_HOST"].";port=".$_ENV["DB_PORT"].";dbname=".$_ENV["DB_NAME"]."", $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], self::OPTIONS);
            } catch (Exception $e) {
                header("Content-Type: application/json");
                echo json_encode(["msg" => $e->getMessage(), "error" => true]);
            }
        }

        return self::$con;
    }
}