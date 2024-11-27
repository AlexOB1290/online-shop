<?php
require_once './Product.php';

class CatalogController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getCatalogPage()
    {
        $this->checkSession();

        $productsData = $this->productModel->getAllProducts();

        if ($productsData === false){
            echo "<p>Ошибка при загрузке данных о товарах на сайт</p>";
        } else {
            require './catalog.php';
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
