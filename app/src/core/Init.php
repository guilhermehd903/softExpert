<?php

use Softexpert\Mercado\core\Router;
use Dotenv\Dotenv;
use Softexpert\Mercado\middlewares\AuthMiddleware;
use Softexpert\Mercado\middlewares\IsAdminMiddleware;
use Softexpert\Mercado\middlewares\IsUsuarioMiddleware;

$dotenv = Dotenv::createImmutable(__DIR__."/../..");
$dotenv->load();
$router = new Router();

$router->get("/", "HomeController@index");
$router->get("/swagger/:file", "HomeController@getFile");
$router->get("/me", "AuthController@me", [AuthMiddleware::class]);

$router->post("/auth", "AuthController@index");

//Usuario
$router->get("/usuarios", "UsuarioController@getAll", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->post("/usuario", "UsuarioController@index", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->put("/usuario/:id", "UsuarioController@edit", [AuthMiddleware::class, IsUsuarioMiddleware::class]);
$router->delete("/usuario/:id", "UsuarioController@delete", [AuthMiddleware::class, IsAdminMiddleware::class]);

//Categoria
$router->get("/categorias", "CategoriaController@getAll", [AuthMiddleware::class]);
$router->post("/categoria", "CategoriaController@index", [AuthMiddleware::class, IsAdminMiddleware::class]);
$router->delete("/categoria/:id", "CategoriaController@delete", [AuthMiddleware::class, IsAdminMiddleware::class]);

//Produto
$router->get("/produtos", "ProdutoController@getAll", [AuthMiddleware::class]);
$router->post("/produto", "ProdutoController@index", [AuthMiddleware::class]);
$router->delete("/produto/:id", "ProdutoController@delete", [AuthMiddleware::class]);
//Venda
$router->get("/vendas", "VendaController@getAll", [AuthMiddleware::class]);
$router->get("/venda/status/aberta", "VendaController@getOneOpen", [AuthMiddleware::class]);
$router->get("/venda/:id", "VendaController@getOne", [AuthMiddleware::class]);
$router->get("/vendas/me", "VendaController@getAllByVendedor", [AuthMiddleware::class]);
$router->get("/venda/cpf/:cpf", "VendaController@getOneByCpf");
$router->post("/venda/status/aberta/:id", "VendaController@addToCart", [AuthMiddleware::class]);
$router->post("/venda", "VendaController@index", [AuthMiddleware::class]);
$router->put("/venda/:id", "VendaController@editVenda", [AuthMiddleware::class]);
$router->delete("/venda/status/aberta/:id", "VendaController@removeFromCart", [AuthMiddleware::class]);
$router->put("/venda/status/aberta/:id", "VendaController@editFromCart", [AuthMiddleware::class]);

//Swagger
$router->get("/docs", "DocumentationController@index");
$router->get("/api", "DocumentationController@json");

$router->run();