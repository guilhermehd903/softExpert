<?php

use Softexpert\Mercado\Core\Router;
use Dotenv\Dotenv;
use Softexpert\Mercado\middlewares\AuthMiddleware;
use Softexpert\Mercado\middlewares\IsAdminMiddleware;

$dotenv = Dotenv::createImmutable(__DIR__."/../..");
$dotenv->load();
$router = new Router();

$router->get("/", "HomeController@index");
$router->get("/me", "AuthController@me", [AuthMiddleware::class]);

$router->post("/auth", "AuthController@index");

//Usuario
$router->get("/usuarios", "UsuarioController@getAll", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->get("/usuario/:id", "UsuarioController@getOne", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->post("/usuario", "UsuarioController@index", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->put("/usuario/:id", "UsuarioController@edit", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->delete("/usuario/:id", "UsuarioController@delete", [AuthMiddleware::class, IsAdminMiddleware::class]);

//Categoria
$router->get("/categorias", "CategoriaController@getAll", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->get("/categoria/:id", "CategoriaController@getOne", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->post("/categoria", "CategoriaController@index", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->put("/categoria/:id", "CategoriaController@edit", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->delete("/categoria/:id", "CategoriaController@delete", [AuthMiddleware::class, IsAdminMiddleware::class]);

//Produto
$router->get("/produtos", "ProdutoController@getAll", [AuthMiddleware::class]);
$router->get("/produto/:id", "ProdutoController@getOne", [AuthMiddleware::class]);
$router->post("/produto", "ProdutoController@index", [AuthMiddleware::class]);
$router->put("/produto/:id", "ProdutoController@edit", [AuthMiddleware::class]);
$router->delete("/produto/:id", "ProdutoController@delete", [AuthMiddleware::class]);
//Venda
$router->get("/vendas", "VendaController@getAll", [AuthMiddleware::class]);
$router->get("/venda/:id", "VendaController@getOne", [AuthMiddleware::class]);
$router->get("/venda/cpf/:cpf", "VendaController@getOneByCpf", [AuthMiddleware::class]);
$router->post("/venda", "VendaController@index", [AuthMiddleware::class]);

//Swagger
$router->get("/docs", "DocumentationController@index");

$router->run();