<?php

namespace Model;

class Review extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $orderProductId;
    private int $rating;
    private string $positive;
    private string $negative;
    private string $comment;
    private string $createdAt;

    public static function create(int $userId, int $productId, int $orderProductId, int $rating, string $positive, string $negative, string $comment, string $createdAt): bool
    {
        $stmt = self::getPdo()->prepare("INSERT INTO reviews (user_id, product_id, order_product_id, rating, positive, negative, comment, created_at) VALUES (:user_id, :product_id, :order_product_id, :rating, :positive, :negative, :comment, :created_at)");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'order_product_id' => $orderProductId, 'rating' => $rating, 'positive' => $positive, 'negative' => $negative, 'comment' => $comment, 'created_at' => $createdAt]);
    }

    public static function getOneByOrderProductId(int $orderProductId): ?self
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM reviews WHERE order_product_id = :order_product_id");
        $stmt->execute(['order_product_id' => $orderProductId]);
        $data = $stmt->fetch();

        if($data === false){
            return null;
        }

        return self::createObject($data);
    }

    private static function createObject(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->orderProductId = $data['order_product_id'];
        $obj->rating = $data['rating'];
        $obj->positive = $data['positive'];
        $obj->negative = $data['negative'];
        $obj->comment = $data['comment'];
        $obj->createdAt = $data['created_at'];

        return $obj;
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

    public function getOrderProductId(): int
    {
        return $this->orderProductId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getPositive(): string
    {
        return $this->positive;
    }

    public function getNegative(): string
    {
        return $this->negative;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}