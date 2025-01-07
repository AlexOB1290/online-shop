<?php

namespace DTO;

class ReviewDTO
{
    public function __construct(
        private int $userId,
        private int $productId,
        private int $orderProductId,
        private int $rating,
        private string $positive,
        private string $negative,
        private string $comment,
        private string $createdAt
    ) {
        $this->userId = $userId;
        $this->productId = $productId;
        $this->orderProductId = $orderProductId;
        $this->rating = $rating;
        $this->positive = $positive;
        $this->negative = $negative;
        $this->comment = $comment;
        $this->createdAt = $createdAt;
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