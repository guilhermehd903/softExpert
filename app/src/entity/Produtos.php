<?php

namespace Softexpert\Mercado\entity;

use Exception;
use Softexpert\Mercado\core\Model;

class Produtos extends Model
{
    protected $required = ["nome", "preco", "descricao", "categoria_id"];
    public function __construct()
    {
        parent::__construct($this->required);
    }

    public function categoria()
    {
        if ($this->categoria_id) {
            try {
                $cat = new Categoria();
                $cat = $cat->findById($this->categoria_id);

                if (!$cat)
                    return false;

                return $cat->getData();

            } catch (Exception $e) {
                return false;
            }
        }

        return null;
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

        if ($this->categoria_id && !is_numeric($this->categoria_id)) {
            $this->setError("Informe um valor valido para campo categoria_id");
            return false;
        }

        return true;
    }
}