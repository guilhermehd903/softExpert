<?php

namespace Softexpert\Mercado\core;

class Params{
    public $p;

    public function __set($attr, $valor): void{
        $valor = preg_replace('/[^a-zA-Z0-9-]/', '', $valor);
        $valor = trim($valor);

        $this->p[$attr] = $valor;
    }

    public function __get($attr): string{
        return (isset($this->p[$attr])) ? $this->p[$attr] : "";
    }
}

