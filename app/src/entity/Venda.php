<?php

namespace Softexpert\Mercado\entity;

use Exception;
use Softexpert\Mercado\core\Model;

class Venda extends Model
{
    protected $required = [];
    public function __construct()
    {
        parent::__construct($this->required);
    }

    public function vendedor()
    {
        if (isset($this->vendedor_id)) {
            try {
                $vend = new Usuario();
                $vend = $vend->findById($this->vendedor_id);

                if (!$vend)
                    return false;

                return $vend->getData();
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public function save()
    {
        if (!$this->validate())
            return false;


        return parent::save();
    }

    public function findByCpf($cpf)
    {
        try {
            $stmt = self::getInstance()->prepare("SELECT * FROM {$this->entity} WHERE cpf = :cpf ORDER BY created_at DESC LIMIT 1");
            $stmt->bindValue(":cpf", $cpf);
            $stmt->execute();

            return $stmt->fetchObject(get_called_class());
        } catch (Exception $e) {
            return false;
        }
    }

    public function findByMe($user, $role)
    {
        try {
            $chunk = ($role != "admin") ? "vendedor_id = :id AND" : "";

            $stmt = self::getInstance()->prepare("SELECT * FROM {$this->entity} WHERE {$chunk} open = :open");
            if ($role != "admin") {
                $stmt->bindValue(":id", $user);
            }
            $stmt->bindValue(":open", 0);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        } catch (Exception $e) {
            return false;
        }
    }

    public function findOpen($user)
    {
        try {
            $stmt = self::getInstance()->prepare("SELECT * FROM {$this->entity} WHERE open = :open AND vendedor_id = :id");
            $stmt->bindValue(":open", 1);
            $stmt->bindValue(":id", $user);
            $stmt->execute();

            return $stmt->fetchObject(get_called_class());
        } catch (Exception $e) {
            return false;
        }
    }

    public function validate(): bool
    {
        return true;
    }
}