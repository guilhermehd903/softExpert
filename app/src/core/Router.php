<?php

namespace Softexpert\Mercado\core;

class Router extends Routes
{

    public function run(): void
    {
        $controller = "HomeController";
        $action = "index";

        $method = method();
        $url = requestUrl();

        $args = new Params();

        foreach ($this->routes->$method as $req) {
            $pattern = preg_replace('(\:[a-z0-9]{1,})', '([a-z0-9-]{1,})', $req->endpoint);

            if (preg_match('#^(' . $pattern . ')*$#i', $url, $matches) === 1) {
                array_shift($matches);
                array_shift($matches);

                $itens = array();
                if (preg_match_all('(\:[a-z0-9]{1,})', $req->endpoint, $m)) {
                    $itens = preg_replace('(\:)', '', $m[0]);
                }

                foreach ($matches as $key => $match) {
                    $attr = $itens[$key];
                    $args->$attr = $match;
                }

                //executing middleware
                foreach ($req->middleware as $midd) {
                    $obj = new $midd;
                    if (!$obj->run($args)) {
                        $obj->blockedResponse();
                        exit;
                    }
                }

                $path = explode("@", $req->path);
                $controller = $path[0];
                $action = $path[1];
            }
        }

        $controller = "Softexpert\\Mercado\\controllers\\{$controller}";
        $definedController = new $controller();

        $definedController->$action($args);


    }
}