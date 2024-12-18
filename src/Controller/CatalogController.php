<?php
namespace Controller;

use Model\Product;
use Service\CartService;

class CatalogController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getCatalogPage(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];

        $products = $this->productModel->getAll();

        $obj = new CartService();
        $count = $obj->getCount($userId);

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
