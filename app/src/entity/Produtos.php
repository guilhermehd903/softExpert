<?php

namespace Softexpert\Mercado\entity;

use Exception;
use Softexpert\Mercado\core\Model;

class Produtos extends Model
{
    protected $required = ["nome", "preco", "estoque", "descricao", "categoria_id"];
    public function __construct()
    {
        parent::__construct($this->required);
    }

    public function save()
    {
        if (!$this->validate())
            return false;


        return parent::save();
    }

    public function validate(): bool
    {
        // if ($this->preco && !is_numeric($this->preco)) {
        //     $this->setError("Informe um valor valido para campo preco");
        //     return false;
        // }

        if ($this->estoque && !is_numeric($this->estoque)) {
            $this->setError("Informe um valor valido para campo estoque");
            return false;
        }

        if ($this->categoria_id && !is_numeric($this->categoria_id)) {
            $this->setError("Informe um valor valido para campo categoria_id");
            return false;
        }

        return true;
    }
}