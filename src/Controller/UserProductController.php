<?php
namespace Controller;

use Model\Product;
use Model\UserProduct;
use Request\AddProductRequest;

class UserProductController
{
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }

    public function getAddProductForm(): void
    {
        $this->checkSession();
        require_once './../View/get_add_product.php';
    }

    public function handleAddProductForm(AddProductRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $this->checkSession();

            $userId = $_SESSION['user_id'];
            $productId = $request->getProductId();
            $amount = $request->getAmount();

            $userProduct = $this->userProductModel->getOneByIds($userId, $productId);

            if (!$userProduct) {
                $this->userProductModel->addProduct($userId, $productId, $amount);
            } else {
                $this->userProductModel->increaseAmount($amount, $userId, $productId);
            }

            $userProducts = $this->userProductModel->getAllByUserId($userId);

            if ($userProducts) {
                $amount = 0;

                foreach ($userProducts as $userProduct) {
                    $amount += $userProduct->getAmount();
                }

                $count = $amount;
            }
        }

        $products = $this->productModel->getAll();

        require_once './../View/catalog.php';
    }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}
