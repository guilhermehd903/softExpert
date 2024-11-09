<?php

namespace Softexpert\Mercado\entity;

use Exception;

use Softexpert\Mercado\core\Model;

class Categoria extends Model
{
    protected $required = ["nome", "imposto"];
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
        if ($this->imposto && !is_numeric($this->imposto)) {
            $this->setError("Informe um valor valido para campo imposto");
            return false;
        }

        return true;
    }
}