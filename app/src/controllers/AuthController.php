<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Jwt;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Usuario;

class AuthController
{
    use Request;
    use Response;

    public function __construct()
    {
        $this->initRequest();
        $this->initResponse();
    }
    public function index(): void
    {
        $code = $this->body->code;

        $user = new Usuario();
        $user = $user->findByCode($code);

        if (!$user) {
            $this->error("Usuario não encontrado");
            exit;
        }

        $jwt = new Jwt();
        $token = $jwt->create($user->id);

        $this->success(["jwt" => $token]);
    }

    public function me()
    {
        $me = $this->getUser();

        $user = new Usuario();
        $user = $user->findById($me);

        $this->success($user->getData());
    }
}