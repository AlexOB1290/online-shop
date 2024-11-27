<?php
class UserProduct{
    private PDO $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }

    public function getUserProductByUserIdAndProductId($userId, $productId): mixed
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetch();
    }

    public function addNewUserProduct($userId, $productId, $amount): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function increaseAmountOfUserProduct($amount, $userId, $productId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount =amount + :amount WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);
    }

    public function getUserProductJoinProductByUserId($userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT amount, name, price, description, image FROM products JOIN user_products ON user_products.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

}