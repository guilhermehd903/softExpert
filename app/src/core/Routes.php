<?php

namespace Softexpert\Mercado\core;

use stdClass;

abstract class Routes
{
    protected $routes;

    public function __construct()
    {
        $this->routes = new stdClass();
        $this->routes->get = [];
        $this->routes->post = [];
        $this->routes->delete = [];
        $this->routes->put = [];
    }

    private function create($endpoint, $path, $middleware = []): stdClass
    {
        $obj = new stdClass();
        $obj->endpoint = $endpoint;
        $obj->path = $path;
        $obj->middleware = $middleware;

        return $obj;
    }

    private function itHas($obj, $endpoint): int
    {
        $hasEndpoint = array_filter($obj, function ($item) use ($endpoint) {
            return $item->endpoint === $endpoint;
        });

        return count($hasEndpoint);
    }

    public function get($endpoint, $path, $middleware = []): void
    {
        if ($this->itHas($this->routes->get, $endpoint) == 0) {
            if (!empty($middleware) && !is_array($middleware))
                $middleware = [$middleware];
            $this->routes->get[] = $this->create($endpoint, $path, $middleware);
        }
    }

    public function post($endpoint, $path, $middleware = []): void
    {
        if ($this->itHas($this->routes->post, $endpoint) == 0) {
            if (!empty($middleware) && !is_array($middleware))
                $middleware = [$middleware];
            $this->routes->post[] = $this->create($endpoint, $path, $middleware);
        }
    }

    public function put($endpoint, $path, $middleware = []): void
    {
        if ($this->itHas($this->routes->put, $endpoint) == 0) {
            if (!empty($middleware) && !is_array($middleware))
                $middleware = [$middleware];
            $this->routes->put[] = $this->create($endpoint, $path, $middleware);
        }
    }

    public function delete($endpoint, $path, $middleware = []): void
    {
        if ($this->itHas($this->routes->delete, $endpoint) == 0) {
            if (!empty($middleware) && !is_array($middleware))
                $middleware = [$middleware];
            $this->routes->delete[] = $this->create($endpoint, $path, $middleware);
        }
    }
}