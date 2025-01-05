<?php

namespace Service;

use DTO\ReviewDTO;
use Model\Review;

class ReviewService
{
    public function create(ReviewDTO $reviewDTO): void
    {
        Review::create($reviewDTO->getUserId(), $reviewDTO->getOrderProductId(), $reviewDTO->getRating(), $reviewDTO->getPositive(), $reviewDTO->getNegative(), $reviewDTO->getComment(), $reviewDTO->getCreatedAt());
    }
}