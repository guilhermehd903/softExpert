<?php

namespace Softexpert\Mercado\entity;

use Exception;
use Softexpert\Mercado\core\Model;

class Venda extends Model
{
    protected $required = ["metodo"];
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
        return true;
    }
}