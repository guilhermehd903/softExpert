<?php

namespace Softexpert\Mercado\middlewares;

use Softexpert\Mercado\core\Jwt;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Usuario;

class IsAdminMiddleware
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
        $token = $this->getUser();
        
        $user = new Usuario();
        $user = $user->findById($token);

        if($user->role != "admin") return false;

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