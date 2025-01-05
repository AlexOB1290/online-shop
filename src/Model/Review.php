<?php

namespace Model;

class Review extends Model
{
    public static function create(int $userId, int $orderProductId, int $rating, string $positive, string $negative, string $comment, string $createdAt): bool
    {
        $stmt = self::getPdo()->prepare("INSERT INTO reviews (user_id, order_product_id, rating, posistive, negative, comment, created_at) VALUES (:user_id, :order_product_id, :rating, :positive, :negative, :comment, :created_at)");
        return $stmt->execute(['user_id' => $userId, 'order_product_id' => $orderProductId, 'rating' => $rating, 'positive' => $positive, 'negative' => $negative, 'comment' => $comment, 'created_at' => $createdAt]);
    }
}