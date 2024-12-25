<?php
namespace Controller;

use Model\Product;
use Service\Auth\AuthServiceInterface;
use Service\CartService;

class CatalogController
{
    private AuthServiceInterface $authService;
    private CartService $cartService;

    public function __construct(AuthServiceInterface $authService, CartService $cartService)
    {
        $this->authService = $authService;
        $this->cartService = $cartService;
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
}
