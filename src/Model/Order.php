<?php
namespace Model;

class Order extends Model
{
    public function create(int $userId, string $orderNumber, string $name, string $email, string $address, string $telephone, string $total, string $date): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, order_number, name, email, address, telephone, total, date) VALUES (:user_id, :order_number, :name, :email, :address, :telephone, :total, :date)");
        return $stmt->execute(['user_id' => $userId, 'name' => $name, 'order_number'=>$orderNumber, 'email' => $email, 'address' => $address, 'telephone' => $telephone, 'total' => $total, 'date' => $date]);
    }

    public function getAllByUserId(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getOneByUserId(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }
}