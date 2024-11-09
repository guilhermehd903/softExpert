<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Params;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Produtos;
use Softexpert\Mercado\utils\Uploader;

class ProdutoController
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
     *     path="/produto",
     *     summary="Registro de produto",
     *     tags={"Produto"},
     *     description="Adiciona um novo produto.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(type="string",property="nome"),
     *              @OA\Property(type="double",property="preco"),
     *              @OA\Property(type="integer",property="estoque"),
     *              @OA\Property(type="string",property="descricao"),
     *              @OA\Property(type="string",property="categoria_id"),
     *          ),
     *       ), 
     *     ),
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function index(): void
    {
        $prod = new Produtos();

        $prod->nome = $this->body->nome;
        $prod->preco = $this->body->preco;
        $prod->descricao = $this->body->descricao;
        $prod->categoria_id = $this->body->categoria_id;

        if ($_FILES["foto"]) {
            $up = new Uploader();
            $image = $up->image($_FILES["foto"], $prod->nome);
            $prod->img = $image;
        }

        $add = $prod->save();

        if (!$add) {
            $this->error($prod->getError());
            exit;
        }

        $this->success($add->getData());
    }

    /**
     * @OA\Get(
     *     path="/produtos",
     *     summary="Obter lista de todos produtos.",
     *     tags={"Produto"},
     *     description="Retorna os dados de todos os produtos.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function getAll()
    {
        $prod = new Produtos();
        $prod = $prod->findAll();

        $this->success(multiObj($prod));
    }

    /**
     * @OA\Delete(
     *     path="/produto/{id}",
     *     summary="Deletar produto.",
     *     tags={"Produto"},
     *     description="Deleta um produto por id.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do produto",
     *         @OA\Schema(type="integer")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

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
}