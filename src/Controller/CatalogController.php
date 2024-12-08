<?php
namespace Controller;
use Model\Product;
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

        $productsData = $this->productModel->getAll();

        if ($productsData === false){
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
