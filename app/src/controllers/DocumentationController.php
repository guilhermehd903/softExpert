<?php

namespace Softexpert\Mercado\controllers;

class DocumentationController
{

    public function __construct()
    {
        $openapi = \OpenApi\Generator::scan([$_SERVER["DOCUMENT_ROOT"].'/app/src/entity']);

        header('Content-Type: application/json');
        echo $openapi->toJson();
    }

    public function index()
    {
        // $html = file_get_contents("./swagger-ui/swagger-ui-master/dist/index.html");

        // echo $html;
    }

    public function __destruct()
    {

    }
}