<?php
namespace Controller;

use Model\UserProduct;
use Service\Auth\AuthServiceInterface;
use Service\CartService;

class CartController
{
    private AuthServiceInterface $authService;
    private CartService $cartService;

    public function __construct(AuthServiceInterface $authService, CartService $cartService)
    {
        $this->authService = $authService;
        $this->cartService = $cartService;
    }

    public function getCartPage(): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
            return;
        }

        $userId = $this->authService->getCurrentUser()->getId();

        $products = $this->cartService->getUserProducts($userId);

        if(isset($products)) {
            $totalAmount = $this->cartService->getTotalAmount($products);
            $totalSum = $this->cartService->getTotalSum($products);
        }

        require_once './../View/cart.php';
    }

    public function clearCart(): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
            return;
        }

        $userId = $this->authService->getCurrentUser()->getId();

        UserProduct::deleteByUserId($userId);

        require_once './../View/cart.php';
    }
}
