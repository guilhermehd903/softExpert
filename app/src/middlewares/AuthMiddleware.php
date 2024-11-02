<?php

namespace Softexpert\Mercado\middlewares;

use Softexpert\Mercado\core\Jwt;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;

class AuthMiddleware
{
    use Request;
    use Response;

    public function __construct()
    {
        $this->initRequest();
        $this->initResponse();
    }

    public function run(): bool
    {
        $token = $this->getToken();

        if (!$token)
            return false;

        $jwt = new Jwt();
        $validate = $jwt->validate($token);

        if (!$validate)
            return false;

        $this->setUser($validate);

        return true;
    }


    public function blockedresponse()
    {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(["error" => true, "msg" => "Acesso não autorizado", "data" => []]);
        exit;
    }

    public function __destruct()
    {

    }
}