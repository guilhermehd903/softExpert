<?php

namespace Softexpert\Mercado\middlewares;

use Softexpert\Mercado\core\Jwt;
use Softexpert\Mercado\core\Params;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Usuario;

class IsUsuarioMiddleware
{
    use Request;
    use Response;

    public function __construct()
    {
        $this->initRequest();
        $this->initResponse();
    }

    public function run(Params $params): bool
    {
        $token = $this->getUser();

        if ($params->id != $token)
            return false;

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