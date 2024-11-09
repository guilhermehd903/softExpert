<?php

namespace Softexpert\Mercado\controllers;

use OpenApi\Annotations as OA;
use Softexpert\Mercado\core\Params;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Categoria;

class CategoriaController
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
     *     path="/categoria",
     *     summary="Registro de categoria",
     *     tags={"Categoria"},
     *     description="Adiciona uma nova categoria.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  type="string",
     *                  property="nome"
     *              ),
     *              @OA\Property(
     *                  type="double",
     *                  property="imposto"
     *              ),
     *          ),
     *       ), 
     *     ),
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/categorias",
     *     summary="Obter lista de todas categorias.",
     *     tags={"Categoria"},
     *     security={{"bearerAuth":{}}},
     *     description="Retorna os dados de todas as categorias.",
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado"),
     * )
     */
    public function getAll()
    {
        $cat = new Categoria();
        $cat = $cat->findAll();

        $this->success(multiObj($cat));
    }

    /**
     * @OA\Delete(
     *     path="/categoria/{id}",
     *     summary="Deletar categoria",
     *     tags={"Categoria"},
     *     description="Deletar uma categoria.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da categoria",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */
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
}