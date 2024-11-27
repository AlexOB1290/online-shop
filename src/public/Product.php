<?php
class Product
{
    private PDO $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }

    public function getAllProducts(): array|false
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getProductById(string $productId): mixed
    {
        $stmt = $this->pdo->prepare("SELECT id FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        return $stmt->fetch();
    }
}
