<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Response;

class DocumentationController
{
    use Response;

    public function __construct()
    {
        $this->initResponse();
    }

    public function index()
    {
        $this->render("swagger/index.html");
    }

    public function json()
    {
        $openapi = \OpenApi\Generator::scan([
            './src/entity',
            './src/controllers'
        ]);

        header('Content-Type: application/json');
        echo $openapi->toJson();
    }

    public function __destruct()
    {

    }
}