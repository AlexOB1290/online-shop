<?php
namespace Model;

class OrderProduct extends Model
{
    public function addUserProduct(string $orderId, array $userProducts): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];
            $amount = $userProduct['amount'];
            $price = $userProduct['price'];

            $res = $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price' => $price]);
        }

        return $res;
    }

    public function getByOrderId($orderId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }
}