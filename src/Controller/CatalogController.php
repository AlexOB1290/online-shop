<?php
namespace Controller;

use Model\Product;
use Service\CartService;

class CatalogController
{
    private Product $productModel;
    private CartService $cartService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->cartService = new CartService();
    }

    public function getCatalogPage(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];

        $products = $this->productModel->getAll();

        $count = $this->cartService->getCount($userId);

        if (!$products){
            echo "<p>Ошибка при загрузке данных о товарах на сайт</p>";
        } else {
            require_once './../View/catalog.php';
        }
    }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}
