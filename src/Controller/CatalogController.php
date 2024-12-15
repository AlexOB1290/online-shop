<?php
namespace Controller;

use Model\Product;
use Model\UserProduct;

class CatalogController
{
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }

    public function getCatalogPage(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];

        $products = $this->productModel->getAll();

        $userProducts = $this->userProductModel->getAllByUserId($userId);

        if ($userProducts) {
            $amount = 0;

            foreach ($userProducts as $userProduct) {
                $amount += $userProduct->getAmount();
            }

            $count = "$amount";
        } else {
            $count = "";
        }

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
