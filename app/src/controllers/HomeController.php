<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Usuario;

class HomeController
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
        $user = new Usuario();
        $user = $user->findById("17");
        $user->nome = "Guiiii";
        $user->save();

        // $user->nome = "Guilherme";
        // $user->cpf = "50306512840";
        // $user->email = "Guilhermegdrag@gmail.com";
        // $user->nasc = "2001-07-01";
        // $user->role = "Guilhermegdrag@gmail.com";
        // $user->profile = "Guilhermegdrag@gmail.com";

        // $user->save();

        $this->success(["name" => $user->nome]);
    }
}