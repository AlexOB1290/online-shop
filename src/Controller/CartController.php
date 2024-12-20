<?php
namespace Controller;

use Model\User;
use Service\CartService;
use Service\AuthService;

class CartController
{
    private CartService $cartService;
    private AuthService $authService;

    public function __construct()
    {
        $this->cartService = new CartService();
        $this->authService = new AuthService();
    }

    public function getCartPage(): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
        }

        $userId = $this->authService->getCurrentUser()->getId();

        $products = $this->cartService->getProducts($userId);

        if(isset($products)) {
            $totalAmount = $this->cartService->getTotalAmount($products);
            $totalSum = $this->cartService->getTotalSum($products);
        }

        require_once './../View/cart.php';
    }
}
