<?php
namespace Model;

class Product extends Model
{
    public function getAll(): array|false
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getOneById(int $productId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        return $stmt->fetch();
    }

    public function getAllWithAmountInCart(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT amount, name, price, description, image FROM products JOIN user_products ON user_products.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getAllByIds(array $productIds): array|false
    {
        $placeHolders = '?' . str_repeat(', ?', count($productIds) - 1);
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id IN ($placeHolders)");
        $stmt->execute($productIds);
        return $stmt->fetchAll();
    }
}
