<?php
require_once './../Model/Product.php';
require_once './../Model/UserProduct.php';
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

    public function handleAddProductForm(): void
    {
        $errors = $this->validateAddProductForm($_POST);

        if (empty($errors)) {
            $this->checkSession();

            $userId = $_SESSION['user_id'];
            $productId = $_POST['product-id'];
            $amount = $_POST['amount'];

            $userProductsData = $this->userProductModel->getAllByIds($userId, $productId);

            if ($userProductsData === false) {
                $this->userProductModel->addProduct($userId, $productId, $amount);
            } else {
                $this->userProductModel->increaseAmount($amount, $userId, $productId);
            }
        }

        require_once './../View/get_add_product.php';
    }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }

    private function validateAddProductForm(array $arrPost): array
    {
        $errors = [];

        if(isset($arrPost['product-id'])){
            $productId = $arrPost['product-id'];
        } else {
            $errors['name'] = "Требуется установить Product-id";
        }

        if(isset($arrPost['amount'])){
            $amount = $arrPost['amount'];
        } else {
            $errors['email'] = "Требуется установить Amount";
        }

        if (empty($productId)) {
            $errors['product-id'] = "Product-id не должно быть пустым";
        } elseif ($productId < 1) {
            $errors['amount'] = "Product-id должно быть положительным числом";
        } elseif (!is_numeric($productId)) {
            $errors['product-id'] = "Product-id должно быть числом";
        } elseif (str_contains($productId, ".")) {
            $errors['product-id'] = "Product-id должно быть натуральным числом";
        } else {
            $productData = $this->productModel->getOneById($productId);

            if ($productData === false) {
                $errors['product-id'] = "Данный товар отсутствует в магазине";
            }
        }

        if (empty($amount)) {
            $errors['amount'] = "Количество продуктов не должен быть пустым";
        } elseif ($amount < 1) {
            $errors['amount'] = "Количество продуктов должно быть положительным";
        } elseif (!is_numeric($amount)) {
            $errors['amount'] = "Количество продуктов должно быть числом";
        } elseif (str_contains($amount, ".")) {
            $errors['amount'] = "Количество должно быть натуральным числом";
        }

        return $errors;
    }
}
