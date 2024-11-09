<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Jwt;
use Softexpert\Mercado\core\Params;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Usuario;
use Softexpert\Mercado\utils\Uploader;

class UsuarioController
{
    use Request;
    use Response;

    public function __construct()
    {
        $this->initRequest();
        $this->initResponse();
    }

    /**
     * @OA\Post(
     *     path="/usuario",
     *     summary="Registro de usuário",
     *     tags={"Usuario"},
     *     description="Adiciona um novo usuário.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(type="string",property="nome"),
     *              @OA\Property(type="string",property="cpf"),
     *              @OA\Property(type="string",property="email"),
     *              @OA\Property(type="string",property="nasc"),
     *              @OA\Property(type="string",property="role"),
     *          ),
     *       ), 
     *     ),
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

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

    /**
     * @OA\Get(
     *     path="/usuarios",
     *     summary="Obter lista de todos usuários.",
     *     tags={"Usuario"},
     *     description="Retorna os dados de todos os usuários.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */
    public function getAll()
    {
        $user = new Usuario();
        $user = $user->findAll();

        $this->success(multiObj($user));
    }

    /**
     * @OA\Delete(
     *     path="/usuario/{id}",
     *     summary="Deletar usuário.",
     *     tags={"Usuario"},
     *     description="Deleta um usuário por id.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *         @OA\Schema(type="integer")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/usuario/{id}",
     *     summary="Editar usuário",
     *     tags={"Usuario"},
     *     description="Editar um usuário por id.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(type="string",property="nome"),
     *              @OA\Property(type="string",property="cpf"),
     *              @OA\Property(type="string",property="email"),
     *              @OA\Property(type="string",property="nasc"),
     *              @OA\Property(type="string",property="role"),
     *          ),
     *       ), 
     *     ),
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function edit(Params $params)
    {
        $user = new Usuario();
        $user = $user->findById($params->id);

        if (!$user) {
            $this->error("Usuario não encontrado", 404);
            exit;
        }

        if (isset($this->body->nome)) {
            $user->nome = $this->body->nome;
        }
        if (isset($this->body->cpf)) {
            $user->cpf = $this->body->cpf;
        }
        if (isset($this->body->email)) {
            $user->email = $this->body->email;
        }
        if (isset($this->body->nasc)) {
            $user->nasc = $this->body->nasc;
        }
        if (isset($this->body->role)) {
            $user->role = $this->body->role;
        }

        if (isset($this->files["foto"])) {
            $up = new Uploader();
            $image = $up->image($this->files["foto"], $this->body->nome);
            $user->profile = $image;
        }

        $edit = $user->save();

        if (!$edit) {
            $this->error($user->getError());
            exit;
        }

        $this->success($edit->getData());
    }
}