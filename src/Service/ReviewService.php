<?php

namespace Service;

use DTO\ReviewDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Review;

class ReviewService
{
    public function create(ReviewDTO $reviewDTO): void
    {
        Review::create($reviewDTO->getUserId(), $reviewDTO->getProductId(), $reviewDTO->getOrderProductId(), $reviewDTO->getRating(), $reviewDTO->getPositive(), $reviewDTO->getNegative(), $reviewDTO->getComment(), $reviewDTO->getCreatedAt());
    }

    public function getReview(int $userId, int $productId): Review
    {
        $orders = Order::getAllByUserId($userId);

        if ($orders) {
            $orderIds = [];
            foreach ($orders as $order) {
                $orderIds[] = $order->getId();
            }

            $orderProducts = OrderProduct::getAllByIds($orderIds);

            foreach ($orderProducts as $orderProduct) {
                if ($orderProduct->getProductId() === $productId) {
                    $obj = Review::getOneByOrderProductId($orderProduct->getId());
                    break;
                }
            }
        }

        return $obj;
    }
}