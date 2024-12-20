<?php
namespace Controller;

use Model\Product;
use Service\CartService;
use Service\AuthService;

class CatalogController
{
    private CartService $cartService;
    private AuthService $authService;

    public function __construct()
    {
        $this->cartService = new CartService();
        $this->authService = new AuthService();
    }

    public function getCatalogPage(): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
        }

        $userId = $this->authService->getCurrentUser()->getId();

        $products = Product::getAll();

        $count = $this->cartService->getCount($userId);

        require_once './../View/catalog.php';
    }
}
