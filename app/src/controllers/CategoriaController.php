<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Jwt;
use Softexpert\Mercado\core\Params;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Categoria;
use Softexpert\Mercado\entity\Usuario;

class CategoriaController
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
        $cat = new Categoria();

        $cat->nome = $this->body->nome;
        $cat->imposto = $this->body->imposto;

        $add = $cat->save();

        if (!$add) {
            $this->error($cat->getError());
            exit;
        }

        $this->success($add->getData());
    }

    public function getAll()
    {
        $cat = new Categoria();
        $cat = $cat->findAll();

        $this->success(multiObj($cat));
    }

    public function getOne(Params $params)
    {
        $cat = new Categoria();
        $cat = $cat->findById($params->id);

        if (!$cat) {
            $this->error("Categoria não encontrado");
            exit;
        }

        $this->success($cat->getData());
    }

    public function delete(Params $params)
    {
        $cat = new Categoria();
        $cat = $cat->delete($params->id);

        if (!$cat) {
            $this->error("Erro ao apagar categoria");
            exit;
        }

        $this->success();
    }

    public function edit(Params $params)
    {
        $cat = new Categoria();
        $cat = $cat->findById($params->id);
        
        if (!$cat) {
            $this->error("Categoria não encontrada");
            exit;
        }

        if ($this->body->nome) {
            $cat->nome = $this->body->nome;
        }
        if ($this->body->imposto) {
            $cat->imposto = $this->body->imposto;
        }

        $edit = $cat->save();

        if (!$edit) {
            $this->error($cat->getError());
            exit;
        }

        $this->success($edit->getData());
    }
}