<?php

namespace Controller;

use DTO\ReviewDTO;
use Model\Product;
use Model\Review;
use Request\ReviewRequest;
use Service\Auth\AuthServiceInterface;
use Service\CartService;
use Service\ReviewService;

class ReviewController
{
    private AuthServiceInterface $authService;
    private CartService $cartService;
    private ReviewService $reviewService;

    public function __construct(AuthServiceInterface $authService, CartService $cartService, ReviewService $reviewService)
    {
        $this->authService = $authService;
        $this->cartService = $cartService;
        $this->reviewService = $reviewService;
    }
    public function getReviewForm(ReviewRequest $request): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
            return;
        }

        $userId = $this->authService->getCurrentUser()->getId();
        $productId = $request->getProductId();

        $product = Product::getOneById($productId);

        $count = $this->cartService->getCount($userId);

        require_once './../View/review.php';
    }

    public function handleReviewForm(ReviewRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $userId = $this->authService->getCurrentUser()->getId();
            $productId = $request->getProductId();
            $rating = $request->getRating();
            $positive = $request->getPositive();
            $negative = $request->getNegative();
            $comment = $request->getComment();
            date_default_timezone_set('Asia/Irkutsk');
            $createdAt = date('d-m-Y H:i:s');

            $count = $this->cartService->getCount($userId);

            $dto = new ReviewDTO($userId, $productId, $rating, $positive, $negative, $comment, $createdAt);
            $this->reviewService->create($dto);

            $review = Review::getOneByUserIdAndProductId($userId, $productId);

            if ($review) {
                $result = "<p> Ваш заказ успешно добавлен! </p>";
            } else {
                $result = "<p> Произошла ошибка при добавлении отзыва! Попробуйте еще раз. </p>";
            }

            require_once './../View/review-result.php';
        } else {
            $productId = $request->getProductId();
            $userId = $this->authService->getCurrentUser()->getId();

            $product = Product::getOneById($productId);

            $count = $this->cartService->getCount($userId);

            require_once './../View/review.php';
        }
    }
}