<?php

namespace Softexpert\Mercado\controllers;

use Softexpert\Mercado\core\Jwt;
use Softexpert\Mercado\core\Request;
use Softexpert\Mercado\core\Response;
use Softexpert\Mercado\entity\Usuario;

class AuthController
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
     *     path="/auth",
     *     tags={"Auth"},
     *     summary="Autenticação",
     *     description="Autenticação de usuário",
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property( type="string", property="code" ),
     *          ),
     *       ), 
     *     ),
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="404", description="Usuário não encontrado")
     * )
     */
    public function index(): void
    {
        $code = $this->body->code;

        $user = new Usuario();
        $user = $user->findByCode($code);

        if (!$user) {
            $this->error("Usuario não encontrado", 404);
            exit;
        }

        $jwt = new Jwt();
        $token = $jwt->create($user->id);

        $this->success(["jwt" => $token, "role" => $user->role]);
    }

    /**
     * @OA\Get(
     *     path="/me",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     summary="Obter dados usuário",
     *     description="Obetem dados do usuário autenticado.",
     *     @OA\Response(response="200", description="Operação bem sucedida"),
     *     @OA\Response(response="404", description="Usuário não encontrado")
     * )
     */
    public function me()
    {
        $me = $this->getUser();

        $user = new Usuario();
        $user = $user->findById($me);

        if (!$user) {
            $this->error("Usuario não encontrado", 404);
            exit;
        }

        $this->success($user->getData());
    }
}