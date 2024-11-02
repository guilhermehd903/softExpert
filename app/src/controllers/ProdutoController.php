<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Params;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Categoria;
use Softexpert\Mercado\entity\Produtos;

class ProdutoController
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
        $prod = new Produtos();

        $prod->nome = $this->body->nome;
        $prod->preco = $this->body->preco;
        $prod->estoque = $this->body->estoque;
        $prod->img = $this->body->img;
        $prod->descricao = $this->body->descricao;
        $prod->categoria_id = $this->body->categoria_id;

        $add = $prod->save();

        if (!$add) {
            $this->error($prod->getError());
            exit;
        }

        $this->success($add->getData());
    }

    public function getAll()
    {
        $prod = new Produtos();
        $prod = $prod->findAll();

        $this->success(multiObj($prod));
    }

    public function getOne(Params $params)
    {
        $prod = new Produtos();
        $prod = $prod->findById($params->id);

        if (!$prod) {
            $this->error("Produto não encontrado");
            exit;
        }

        $this->success($prod->getData());
    }

    public function delete(Params $params)
    {
        $prod = new Produtos();
        $prod = $prod->delete($params->id);

        if (!$prod) {
            $this->error("Erro ao apagar produto");
            exit;
        }

        $this->success();
    }

    public function edit(Params $params)
    {
        $prod = new Produtos();
        $prod = $prod->findById($params->id);

        if (!$prod) {
            $this->error("Produto não encontrada");
            exit;
        }

        if ($this->body->nome) {
            $prod->nome = $this->body->nome;
        }
        if ($this->body->preco) {
            $prod->preco = $this->body->preco;
        }
        if ($this->body->estoque) {
            $prod->estoque = $this->body->estoque;
        }
        if ($this->body->img) {
            $prod->img = $this->body->img;
        }
        if ($this->body->descricao) {
            $prod->descricao = $this->body->descricao;
        }
        if ($this->body->categoria_id) {
            $prod->categoria_id = $this->body->categoria_id;
        }

        $edit = $prod->save();

        if (!$edit) {
            $this->error($prod->getError());
            exit;
        }

        $this->success($edit->getData());
    }
}