<?php
namespace Model;

use PDO;

class Model
{
    protected PDO $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }

    public function hydrate(array $data): self
    {
        foreach ($data as $key => $value) {
            strpos($key, '_');
        }

        return $this;
    }
}