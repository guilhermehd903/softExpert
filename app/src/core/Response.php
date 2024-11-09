<?php

namespace Softexpert\Mercado\core;

use stdClass;
use Twig\Loader\ArrayLoader;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

trait Response
{
    public $response;
    public function initResponse()
    {
        $this->response = new stdClass();

        $this->response->error = false;
        $this->response->msg = "";
        $this->response->data = [];
    }

    public function success($data = [], $code = 200): void
    {
        http_response_code($code);
        $this->response->data = $data;
        $this->response->error = false;
        $this->response->msg = "Requisição realizada com sucesso";
    }

    public function error($msg, $code = 200): void
    {
        http_response_code($code);
        $this->response->error = true;
        $this->response->msg = $msg;
    }

    public function render($path = "")
    {
        $loader = new FilesystemLoader("./src/views");
        $twig = new Environment($loader);

        echo $twig->render($path, [
            "url" => "http://localhost:8080"
        ]);
    }

    public function __destruct()
    {
        header('Content-Type: application/json');
        echo json_encode($this->response);
        exit;
    }
}