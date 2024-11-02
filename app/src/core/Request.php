<?php

namespace Softexpert\Mercado\core;

use Softexpert\Mercado\utils\Auth;
use stdClass;

trait Request
{
    public $body;


    public function setUser($token)
    {
        Auth::setAuth($token);
    }

    public function getUser()
    {
        return Auth::getAuth();
    }

    public function initRequest()
    {
        $this->body = new stdClass();

        if (method() != 'get') {
            $this->body = $this->getRequestData();
        }
    }

    protected function getToken()
    {
        $headers = getallheaders();

        if (!$headers["Authorization"] || empty($headers["Authorization"]))
            return false;

        $token = explode(" ", $headers['Authorization']);

        if (count($token) != 2 || $token[0] != 'Bearer')
            return false;

        return $token[1];
    }

    private function getRequestData()
    {
        switch (method()) {
            case 'put':
            case 'delete':
                return (object) json_decode(file_get_contents("php://input"));
            case 'post':
                $data = json_decode(file_get_contents("php://input"));

                if ($data == null) {
                    $data = $_POST;
                }

                return (object) $data;
        }
    }
}