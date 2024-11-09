<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;

/**
 * @OA\Info(title="API ExpertCart", version="1.0")
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Use um token JWT para autenticação"
 * )
 */

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
        $this->success("pong");
    }
}