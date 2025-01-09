<?php
namespace Model;

class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;

    public static function addProduct(int $userId, int $productId, int $amount): bool
    {
        $stmt = self::getPdo()->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public static function increaseAmount(int $amount, int $userId, int $productId): bool
    {
        $stmt = self::getPdo()->prepare("UPDATE user_products SET amount =amount + :amount WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);
    }

    public static function decreaseAmount(int $amount, int $userId, int $productId): bool
    {
        $stmt = self::getPdo()->prepare("UPDATE user_products SET amount =amount - :amount WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);
    }

    public static function getOneByIds(int $userId, int $productId): ?self
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return self::createObject($data);
    }

    public static function getAllByUserId(int $userId): ?array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchAll();

        if ($data === false) {
            return null;
        }

        $userProducts = [];
        foreach ($data as $userProduct) {
            $userProducts[] = self::createObject($userProduct);
        }

        return $userProducts;
    }

    private static function createObject(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->amount = $data['amount'];

        return $obj;
    }

    public static function deleteByUserId(int $userId): bool
    {
        $stmt = self::$pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        return $stmt->execute(['user_id' => $userId]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}