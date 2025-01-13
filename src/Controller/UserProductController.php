<?php
namespace Controller;

use DTO\CartDTO;
use Model\Product;
use Model\Review;
use Model\UserProduct;
use Request\AddProductRequest;
use Service\Auth\AuthServiceInterface;
use Service\CartService;
use Service\ReviewService;

class UserProductController
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

    public function getAddProductForm(): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
            return;
        }
        require_once './../View/get_add_product.php';
    }

    public function handleAddProductForm(AddProductRequest $request): void
    {
        $errors = $request->validate();

        $userId = $this->authService->getCurrentUser()->getId();

        if (empty($errors)) {
            $productId = $request->getProductId();
            $amount = $request->getAmount();

            $dto = new CartDTO($userId, $productId, $amount);

            $this->cartService->create($dto);
        }

        $products = Product::getAll();
        $reviews = Review::getAll();

        $this->reviewService->setAverageRating($products, $reviews);
        $count = $this->cartService->getCount($userId);

        require_once './../View/catalog.php';
    }

    public function addOne(AddProductRequest $request): void
    {
        $errors = $request->validate();

        $userId = $this->authService->getCurrentUser()->getId();

        if (empty($errors)) {
            $productId = $request->getProductId();
            $amount = $request->getAmount();

            $dto = new CartDTO($userId, $productId, $amount);

            $this->cartService->addOne($dto);
        }

        $products = $this->cartService->getUserProducts($userId);

        if(isset($products)) {
            $totalAmount = $this->cartService->getTotalAmount($products);
            $totalSum = $this->cartService->getTotalSum($products);
        }

        require_once './../View/cart.php';
    }

    public function deleteOne(AddProductRequest $request): void
    {
        $errors = $request->validate();

        $userId = $this->authService->getCurrentUser()->getId();

        if (empty($errors)) {
            $productId = $request->getProductId();
            $amount = $request->getAmount();

            $userProducts = UserProduct::getOneByIds($userId, $productId);

            if ($userProducts->getAmount() > 1) {
                $dto = new CartDTO($userId, $productId, $amount);

                $this->cartService->deleteOne($dto);
            }
        }

        $products = $this->cartService->getUserProducts($userId);

        if(isset($products)) {
            $totalAmount = $this->cartService->getTotalAmount($products);
            $totalSum = $this->cartService->getTotalSum($products);
        }

        require_once './../View/cart.php';
    }
}
