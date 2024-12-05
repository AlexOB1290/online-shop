<?php
require_once './../Model/PdoConnection.php';
class OrderProduct extends PdoConnection
{
    public function addUserProduct($orderId, $productId, $amount, $price): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        return $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price' => $price]);
    }

    public function getByOrderId($orderId): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }
}