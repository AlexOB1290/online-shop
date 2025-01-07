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
        if ($this->check($reviewDTO->getUserId(), $reviewDTO->getProductId()))
        {
            $obj = Review::getOneByUserIdAndProductId($reviewDTO->getUserId(), $reviewDTO->getProductId());

            if(!$obj) {
                Review::create($reviewDTO->getUserId(), $reviewDTO->getProductId(), $reviewDTO->getRating(), $reviewDTO->getPositive(), $reviewDTO->getNegative(), $reviewDTO->getComment(), $reviewDTO->getCreatedAt());
            } else {
                header('Location: /catalog');
            }
        }
    }

    public function check(int $userId, int $productId): bool
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
                    return true;
                }
            }
        }

        return false;
    }
}