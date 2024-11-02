<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Jwt;
use Softexpert\Mercado\core\Params;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Usuario;

class UsuarioController
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

        $user->nome = $this->body->nome;
        $user->cpf = $this->body->cpf;
        $user->email = $this->body->email;
        $user->nasc = $this->body->nasc;
        $user->role = $this->body->role;

        $user->profile = $this->body->profile;

        $access = \rand(100000, 999999);

        $user->access = $access;

        $add = $user->save();

        if (!$add) {
            $this->error($user->getError());
            exit;
        }

        $this->success($add->getData());
    }

    public function getAll()
    {
        $user = new Usuario();
        $user = $user->findAll();

        $this->success(multiObj($user));
    }

    public function getOne(Params $params)
    {
        $user = new Usuario();
        $user = $user->findById($params->id);

        if (!$user) {
            $this->error("Usuario não encontrado");
            exit;
        }

        $this->success($user->getData());
    }

    public function delete(Params $params)
    {
        $user = new Usuario();
        $user = $user->delete($params->id);

        if (!$user) {
            $this->error("Erro ao apagar usuaio");
            exit;
        }

        $this->success();
    }

    public function edit(Params $params)
    {
        $user = new Usuario();
        $user = $user->findById($params->id);

        if (!$user) {
            $this->error("Usuario não encontrado");
            exit;
        }

        if ($this->body->nome) {
            $user->nome = $this->body->nome;
        }
        if ($this->body->cpf) {
            $user->cpf = $this->body->cpf;
        }
        if ($this->body->email) {
            $user->email = $this->body->email;
        }
        if ($this->body->nasc) {
            $user->nasc = $this->body->nasc;
        }
        if ($this->body->role) {
            $user->role = $this->body->role;
        }
        if ($this->body->profile) {
            $user->profile = $this->body->profile;
        }

        $edit = $user->save();

        if (!$edit) {
            $this->error($user->getError());
            exit;
        }

        $this->success($edit->getData());
    }
}