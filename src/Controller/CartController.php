<?php
namespace Controller;

use Model\User;
use Service\CartService;

class CartController
{
    private User $userModel;
    private CartService $cartService;

    public function __construct()
    {
        $this->userModel = new User();
        $this->cartService = new CartService();
    }

    public function getCartPage(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];

        $user = $this->userModel->getOneById($userId);

        $products = $this->cartService->getProducts($userId);


        require_once './../View/cart.php';
    }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}
