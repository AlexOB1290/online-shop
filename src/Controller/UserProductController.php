<?php
namespace Controller;

use DTO\CartDTO;
use Model\Product;
use Model\UserProduct;
use Request\AddProductRequest;
use Service\CartService;
use Service\AuthService;

class UserProductController
{
    private CartService $cartService;
    private AuthService $authService;

    public function __construct()
    {
        $this->cartService = new CartService();
        $this->authService = new AuthService();
    }

    public function getAddProductForm(): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
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

            $count = $this->cartService->getCount($userId);
        }

        $products = Product::getAll();
        $count = $this->cartService->getCount($userId);

        require_once './../View/catalog.php';
    }
}
