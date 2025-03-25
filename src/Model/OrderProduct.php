<?php
namespace Model;

class OrderProduct extends Model
{
    protected int $id;
    protected int $orderId;
    protected int $productId;
    protected int $amount;
    protected int $price;

    public static function addUserProduct(string $orderId, array $userProducts): bool
    {
        $stmt = self::getPdo()->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getId();
            $amount = $userProduct->getAmount();
            $price = $userProduct->getPrice();

            $result = $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price' => $price]);
        }

        return $result;
    }

    public static function getByOrderId($orderId): ?array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM order_products WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        $data = $stmt->fetchAll();

        if ($data === false){
            return null;
        }

        $orderProducts = [];
        foreach ($data as $orderProduct){
            $orderProducts[] = self::createObjectAut($orderProduct);
        }

        return $orderProducts;
    }

    public static function getAllByIds(array $orderIds): ?array
    {
        $placeHolders = '?' . str_repeat(', ?', count($orderIds) - 1);
        $stmt = self::getPdo()->prepare("SELECT * FROM order_products WHERE order_id IN ($placeHolders)");
        $stmt->execute($orderIds);
        $data = $stmt->fetchAll();

        if($data === false) {
            return null;
        }

        $orderProducts = [];
        foreach ($data as $orderProduct) {
            $orderProducts[] = self::createObjectAut($orderProduct);
        }

        return $orderProducts;
    }

    private static function createObject (array $data): self
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