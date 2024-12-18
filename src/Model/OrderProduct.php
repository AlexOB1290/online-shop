<?php
namespace Model;

class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    private int $price;

    public function addUserProduct(string $orderId, array $userProducts): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();
            $price = $userProduct->getPrice();

            $result = $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price' => $price]);
        }

        return $result;
    }

    public function getByOrderId($orderId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        $data = $stmt->fetchAll();

        if ($data === false){
            return null;
        }

        $orderProducts = [];
        foreach ($data as $orderProduct){
            $orderProducts[] = $this->createObject($orderProduct);
        }

        return $orderProducts;
    }

    private function createObject (array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->orderId = $data['order_id'];
        $obj->productId = $data['product_id'];
        $obj->amount = $data['amount'];
        $obj->price = $data['price'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}