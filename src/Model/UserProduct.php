<?php
namespace Model;
class UserProduct extends Model
{
    public function getAllByIds(int $userId, int $productId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetch();
    }

    public function addProduct(int $userId, int $productId, int $amount): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function increaseAmount(int $amount, int $userId, int $productId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount =amount + :amount WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);
    }

    public function getAllByUserId(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function deleteByUserId(int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        return $stmt->execute(['user_id' => $userId]);
    }
}