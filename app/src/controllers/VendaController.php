<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Params;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Categoria;
use Softexpert\Mercado\entity\Produtos;
use Softexpert\Mercado\entity\Venda;

class VendaController
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
        $venda = new Venda();

        $venda->metodo = $this->body->metodo;
        $venda->cpf = $this->body->cpf;

        $add = $venda->save();

        if (!$add) {
            $this->error($venda->getError());
            exit;
        }

        $this->success($add->getData());
    }

    public function getAll()
    {
        $venda = new Venda();
        $venda = $venda->findAll();

        $this->success(multiObj($venda));
    }

    public function getOne(Params $params)
    {
        $venda = new Venda();
        $venda = $venda->findById($params->id);

        if (!$venda) {
            $this->error("Venda não encontrado");
            exit;
        }

        $this->success($venda->getData());
    }
}