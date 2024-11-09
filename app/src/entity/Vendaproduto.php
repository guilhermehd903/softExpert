<?php

namespace Softexpert\Mercado\entity;

use Exception;
use Softexpert\Mercado\core\Model;

class Vendaproduto extends Model
{
    protected $required = ["venda_id", "produto_id", "qtd"];
    public function __construct()
    {
        parent::__construct($this->required);
    }

    public function produto()
    {
        if ($this->produto_id) {
            try {
                $prod = new Produtos();
                $prod = $prod->findById($this->produto_id);

                if (!$prod)
                    return false;

                $produto = $prod->getData();
                $produto["categoria"] = $prod->categoria();
                return $produto;

            } catch (Exception $e) {
                return false;
            }
        }

        return null;
    }

    public function findByVenda($venda){
        try{
            $stmt = $this->getInstance()->prepare("SELECT * FROM {$this->entity} WHERE venda_id = :vID");
            $stmt->bindValue(':vID',$venda);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }catch(Exception $e){
            return false;
        }
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