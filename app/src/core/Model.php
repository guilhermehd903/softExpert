<?php

namespace Softexpert\Mercado\core;

use Exception;

class Model extends Connect
{
    private $fields;
    protected $entity;
    private $required;
    private $error;

    public function __construct($required)
    {
        $entity = explode("\\", get_called_class());
        $this->entity = strtolower(end($entity));

        $this->required = $required;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function delete($id)
    {
        try {
            $stmt = self::getInstance()->prepare("DELETE FROM {$this->entity} WHERE id = :id");
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function save()
    {
        try {
            $data = (array) $this->fields;

            if (strlen($this->id) > 0) {
                $dataSet = [];

                foreach ($data as $i => $item) {
                    $dataSet[] = "{$i} = :{$i}";
                }

                $dataSet = implode(',', $dataSet);

                $stmt = self::getInstance()->prepare("UPDATE " . $this->entity . " SET {$dataSet} WHERE id = :id");
                $stmt->execute($data);

                return $this->findById($this->id);
            } else {
                if ($this->verify()) {
                    $this->setError("Informe todos os campos obrigatórios");
                    return false;
                }

                $columns = implode(", ", array_keys($data));
                $values = ":" . implode(", :", array_keys($data));

                $stmt = self::getInstance()->prepare("INSERT INTO " . $this->entity . " ({$columns}) VALUES ({$values})");
                $stmt->execute($data);

                return $this->findById(self::getInstance()->lastInsertId());
            }
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public function findById($id)
    {
        try {
            $stmt = self::getInstance()->prepare("SELECT * FROM {$this->entity} WHERE id = :id");
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            return $stmt->fetchObject(get_called_class());
        } catch (Exception $e) {
            return false;
        }
    }

    public function findAll()
    {
        try {
            $stmt = self::getInstance()->query("SELECT * FROM {$this->entity}");

            return $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        } catch (Exception $e) {
            return false;
        }
    }

    protected function verify(): bool
    {
        $data = array_filter((array) $this->fields);
        $diffs = array_diff($this->required, array_keys($data));

        if (empty($diffs)) {
            return false;
        }

        return true;
    }

    public function getData()
    {
        return (array) get_object_vars($this)["fields"];
    }

    public function __set($name, $value): void
    {
        if (empty($this->fields)) {
            $this->fields = new \stdClass();
        }

        $this->fields->$name = $value;
    }

    public function __get($name): string|null
    {
        if (isset($this->fields->$name)) {
            return $this->fields->$name;
        }

        return null;
    }
}