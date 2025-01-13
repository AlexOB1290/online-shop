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

    public function getAverageRating(array $reviews): float
    {
        $average = 0;
        foreach ($reviews as $review) {
            $average += $review->getRating();
        }
        return round($average/count($reviews), 1);
    }

    public function setAverageRating(array $products, array $reviews): void
    {
        foreach ($products as &$product) {
            $ratingSum = 0;
            $i = 0;
            foreach ($reviews as $review) {
                if ($product->getId() === $review->getProductId()) {
                    $ratingSum += $review->getRating();
                } else {
                    continue;
                }
                $i++;
            }
            $avgRating = $ratingSum / $i;
            $product->setAvgRating(round($avgRating, 1));
        }
        unset($product);
    }
}