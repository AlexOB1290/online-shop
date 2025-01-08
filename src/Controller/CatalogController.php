<?php
namespace Controller;

use Model\Product;
use Model\Review;
use Request\CatalogRequest;
use Service\Auth\AuthServiceInterface;
use Service\CartService;
use Service\ReviewService;

class CatalogController
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

    public function getCatalogPage(): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
            return;
        }

        $userId = $this->authService->getCurrentUser()->getId();

        $products = Product::getAll();

        $count = $this->cartService->getCount($userId);

        require_once './../View/catalog.php';
    }

    public function getProductCard(CatalogRequest $request): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
            return;
        }

        $productId = $request->getProductId();

        $userId = $this->authService->getCurrentUser()->getId();

        $product = Product::getOneById($productId);

        $count = $this->cartService->getCount($userId);

        $check = $this->reviewService->check($userId, $productId);

        if($check){
            $review = Review::getOneByUserIdAndProductId($userId, $productId);
        }

        $reviews = $this->reviewService->getReviews($productId);
        if ($reviews) {
            $avgRating = $this->reviewService->getAverageRating($reviews);
        }

        require_once './../View/product_card.php';
    }
}
