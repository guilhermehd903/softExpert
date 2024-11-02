<?php

namespace Softexpert\Mercado\core;

use stdClass;

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

    public function success($data = []): void
    {
        $this->response->data = $data;
        $this->response->error = false;
        $this->response->msg = "Requisição realizada com sucesso";
    }

    public function error($msg): void
    {
        $this->response->error = true;
        $this->response->msg = $msg;
    }

    public function __destruct()
    {
        header('Content-Type: application/json');
        echo json_encode($this->response);
        exit;
    }
}