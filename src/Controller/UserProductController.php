<?php
namespace Controller;

use DTO\CartDTO;
use Model\Product;
use Request\AddProductRequest;
use Service\Auth\AuthServiceInterface;
use Service\CartService;

class UserProductController
{
    private AuthServiceInterface $authService;
    private CartService $cartService;

    public function __construct(AuthServiceInterface $authService, CartService $cartService)
    {
        $this->authService = $authService;
        $this->cartService = $cartService;
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

            $count = $this->cartService->getCount($userId);
        }

        $products = Product::getAll();
        $count = $this->cartService->getCount($userId);

        require_once './../View/catalog.php';
    }
}
