<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Params;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Categoria;
use Softexpert\Mercado\entity\Produtos;
use Softexpert\Mercado\entity\Usuario;
use Softexpert\Mercado\entity\Venda;
use Softexpert\Mercado\entity\Vendaproduto;

class VendaController
{
    use Request;
    use Response;

    public function __construct()
    {
        $this->initRequest();
        $this->initResponse();
    }

    /**
     * @OA\Get(
     *     path="/venda/status/aberta",
     *     summary="Resgatar venda",
     *     tags={"Venda"},
     *     description="Resgata a venda que esta aberta",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function getOneOpen()
    {
        $user = $this->getUser();

        $venda = new Venda();
        $venda = $venda->findOpen($user);

        if (!$venda) {
            $venda = new Venda();
            $venda->vendedor_id = $user;
            $venda->open = 1;
            $venda = $venda->save();
        }

        $vendaItem = $venda->getData();

        $vendaProduto = new Vendaproduto();
        $vendaProduto = $vendaProduto->findByVenda($venda->id);
        $vendasList = multiObj($vendaProduto);

        $produtos = [];

        $subTotal = 0;
        $total = 0;
        $imposto = 0;

        foreach ($vendasList as $vP) {
            $prod = new Produtos();
            $prod = $prod->findById($vP["produto_id"]);

            $produto = $prod->getData();
            $categoria = $prod->categoria();

            $item = $produto;
            $item["rowId"] = $vP["id"];
            $item["qtd"] = $vP["qtd"];
            $item["categoria"] = $categoria;

            $item["subtotal"] = $produto["preco"] * $vP["qtd"];
            $item["imposto"] = $item["subtotal"] * ($categoria["imposto"] / 100);
            $item["total"] = $item["subtotal"] + $item["imposto"];

            $subTotal += $item["subtotal"];
            $imposto += $item["imposto"];
            $total += $item["total"];

            $produtos[] = $item;
        }

        $vendaItem["produtos"] = $produtos;

        $vendaItem["subtotal"] = $subTotal;
        $vendaItem["imposto"] = $imposto;
        $vendaItem["total"] = $total;

        $this->success($vendaItem);
    }

    /**
     * @OA\Post(
     *     path="/venda/status/aberta/{id}",
     *     summary="Adicionar produto a venda",
     *     tags={"Venda"},
     *     description="Adiciona um produto ao carrinho",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="id da venda",
     *         @OA\Schema(type="string")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function addToCart(Params $params)
    {
        $user = $this->getUser();

        $venda = new Venda();
        $venda = $venda->findOpen($user);

        if (!$venda) {
            $this->error("Venda não encontrada", 404);
            return;
        }

        $vendaProduto = new Vendaproduto();
        $vendaProduto->venda_id = $venda->id;
        $vendaProduto->produto_id = $params->id;
        $vendaProduto->qtd = $this->body->qtd;
        $vendaProduto->save();

        $this->success(true);
    }

    /**
     * @OA\Delete(
     *     path="/venda/status/aberta/{id}",
     *     summary="Remove produto da venda",
     *     tags={"Venda"},
     *     description="Remove um produto do carrinho",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="id da venda",
     *         @OA\Schema(type="string")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function removeFromCart(Params $params)
    {
        $vendaProduto = new Vendaproduto();
        $vendaProduto = $vendaProduto->delete($params->id);

        $this->success(true);
    }

    /**
     * @OA\Put(
     *     path="/venda/status/aberta/{id}",
     *     summary="Edita produto da venda",
     *     tags={"Venda"},
     *     description="Edita um produto do carrinho",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="id da venda",
     *         @OA\Schema(type="string")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function editFromCart(Params $params)
    {
        $vendaProduto = new Vendaproduto();
        $vendaProduto = $vendaProduto->findById($params->id);

        $vendaProduto->qtd = $this->body->qtd;
        $vendaProduto->save();

        $this->success(true);
    }

    /**
     * @OA\Get(
     *     path="/vendas",
     *     summary="Obter lista de todas as vendas.",
     *     tags={"Venda"},
     *     description="Retorna os dados de todas as vendas.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function getAll()
    {
        $venda = new Venda();
        $venda = $venda->findAll();

        $vendas = multiObj($venda);

        $list = [];
        foreach ($vendas as $v) {
            $vendaProduto = new Vendaproduto();
            $vendaProduto = $vendaProduto->findByVenda($v["id"]);
            $vendasList = multiObj($vendaProduto);

            $produtos = [];

            $total = 0;
            $totalImposto = 0;

            foreach ($vendasList as $vP) {
                $prod = new Produtos();
                $prod = $prod->findById($vP["produto_id"]);

                $produto = $prod->getData();
                $categoria = $prod->categoria();

                $item = $produto;
                $item["categoria"] = $categoria;

                $item["total"] = $produto["preco"] * $vP["qtd"];
                $item["totalImposto"] = $item["total"] + $item["total"] * ($categoria["imposto"] / 100);

                $total += $item["total"];
                $totalImposto += $item["totalImposto"];

                $produtos[] = $item;
            }

            $v["produtos"] = $produtos;
            $v["total"] = $total;
            $v["totalImposto"] = $totalImposto;
            $list[] = $v;
        }

        $this->success($list);
    }

    /**
     * @OA\Get(
     *     path="/vendas/me",
     *     summary="Obter lista de todas as vendas.",
     *     tags={"Venda"},
     *     description="Retorna os dados de todas as vendas realizadas pelo usuário.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function getAllByVendedor()
    {
        $venda = new Venda();
        $venda = $venda->findByMe($this->getUser(), $this->getRole());

        $vendas = multiObj($venda);

        $list = [];
        foreach ($vendas as $v) {
            $vendaProduto = new Vendaproduto();
            $vendaProduto = $vendaProduto->findByVenda($v["id"]);
            $vendasList = multiObj($vendaProduto);

            $produtos = [];

            $subTotal = 0;
            $total = 0;
            $imposto = 0;

            if ($this->getRole() == "admin") {
                $vend = new Usuario();

                $vend = $vend->findById($v["vendedor_id"]);

                $v["vendedor"] = $vend->getData();
            } else {
                $v["vendedor"] = "";
            }

            foreach ($vendasList as $vP) {
                $prod = new Produtos();
                $prod = $prod->findById($vP["produto_id"]);

                $produto = $prod->getData();
                $categoria = $prod->categoria();

                $item = $produto;
                $item["qtd"] = $vP["qtd"];
                $item["categoria"] = $categoria;

                $item["subtotal"] = $produto["preco"] * $vP["qtd"];
                $item["imposto"] = $item["subtotal"] * ($categoria["imposto"] / 100);
                $item["total"] = $item["subtotal"] + $item["imposto"];

                $subTotal += $item["subtotal"];
                $imposto += $item["imposto"];
                $total += $item["total"];


                $produtos[] = $item;
            }

            $v["subtotal"] = $subTotal;
            $v["imposto"] = $imposto;
            $v["total"] = $total;
            $v["produtos"] = $produtos;

            $list[] = $v;
        }

        $this->success($list);
    }

    /**
     * @OA\Get(
     *     path="/venda/cpf/{cpf}",
     *     summary="Obter venda por CPF.",
     *     tags={"Venda"},
     *     description="Retorna os dados de uma venda através do CPF.",
     *     @OA\Parameter(
     *         name="cpf",
     *         in="path",
     *         required=true,
     *         description="CPF da venda",
     *         @OA\Schema(type="string")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function getOneByCpf(Params $params)
    {

        $cpf = substr($params->cpf, 0, 3) . '.' . substr($params->cpf, 3, 3) . '.' . substr($params->cpf, 6, 3) . '-' . substr($params->cpf, 9, 2);

        if (!isCpf($cpf)) {
            $this->error("Informe um CPF valido!");
            exit;
        }

        $venda = new Venda();
        $v = $venda->findByCpf($cpf);

        $vendaProduto = new Vendaproduto();
        $vendaProduto = $vendaProduto->findByVenda($v->id);
        $vendasList = multiObj($vendaProduto);

        $produtos = [];

        $subTotal = 0;
        $total = 0;
        $imposto = 0;

        foreach ($vendasList as $vP) {
            $prod = new Produtos();
            $prod = $prod->findById($vP["produto_id"]);

            $produto = $prod->getData();
            $categoria = $prod->categoria();

            $item = $produto;
            $item["qtd"] = $vP["qtd"];
            $item["categoria"] = $categoria;

            $item["subtotal"] = $produto["preco"] * $vP["qtd"];
            $item["imposto"] = $item["subtotal"] * ($categoria["imposto"] / 100);
            $item["total"] = $item["subtotal"] + $item["imposto"];

            $subTotal += $item["subtotal"];
            $imposto += $item["imposto"];
            $total += $item["total"];


            $produtos[] = $item;
        }

        $v->subtotal = $subTotal;
        $v->imposto = $imposto;
        $v->total = $total;
        $v->produtos = $produtos;

        $this->success($v->getData());
    }

    /**
     * @OA\Put(
     *     path="/venda/{id}",
     *     summary="Edição de venda",
     *     tags={"Venda"},
     *     description="Edita uma venda existente.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(type="string",property="metodo"),
     *              @OA\Property(type="string",property="cpf"),
     *              @OA\Property(type="integer",property="open"),
     *          ),
     *       ), 
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="id da venda",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="403", description="Acesso não autorizado")
     * )
     */

    public function editVenda(Params $params): void
    {
        $venda = new Venda();
        $venda = $venda->findById($params->id);

        if (!$venda) {
            $this->error("Venda não encontrada", 404);
            exit;
        }

        if (isset($this->body->metodo)) {
            $venda->metodo = $this->body->metodo;
        }
        if (isset($this->body->cpf)) {
            $venda->cpf = $this->body->cpf;
        }
        if (isset($this->body->open)) {
            $venda->open = (int) $this->body->open;
        }

        $edit = $venda->save();

        if (!$edit) {
            $this->error($venda->getError());
            exit;
        }

        $this->success(true);
    }
}