<?php

namespace Softexpert\Mercado\entity;

use Exception;
use Softexpert\Mercado\core\Model;

class Usuario extends Model
{
    protected $required = ["nome", "cpf", "email", "nasc", "role", "access"];
    const ROLES = [
        "caixa",
        "admin"
    ];
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

    public function findByCode($code)
    {
        try {
            $stmt = self::getInstance()->prepare("SELECT * FROM {$this->entity} WHERE access = :code");
            $stmt->bindValue(":code", $code);
            $stmt->execute();

            return $stmt->fetchObject(get_called_class());
        } catch (Exception $e) {
            return false;
        }
    }

    private function verifyCPF()
    {
        if (strlen($this->cpf) > 0) {
            $select = self::getInstance()->query("SELECT id FROM {$this->entity} WHERE cpf = '{$this->cpf}'");
            return $select->rowCount();
        }

        return false;
    }
    public function verifyAccess()
    {
        if (strlen($this->access) > 0) {
            $select = self::getInstance()->query("SELECT id FROM {$this->entity} WHERE access = '{$this->access}'");
            return $select->rowCount();
        }

        return false;
    }

    public function validate(): bool
    {
        
        if ($this->cpf && !isCPF($this->cpf)) {
            $this->setError("CPF informado é invalido");
            return false;
        }

        if ($this->email && !isEmail($this->email)) {
            $this->setError("E-mail informado é invalido");
            return false;
        }

        if ($this->role && !in_array($this->role, self::ROLES)) {
            $this->setError("Cargo invalido!");
            return false;
        }

        // if ($this->verifyCPF()) {
        //     $this->setError("Usuario com mesmo CPF já existe");
        //     return false;
        // }

        return true;
    }
}