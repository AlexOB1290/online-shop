<?php
namespace Controller;

use DTO\CreateUserProductDTO;
use Model\Product;
use Model\UserProduct;
use Request\AddProductRequest;
use Service\UserProductService;

class UserProductController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    private UserProductService $userProductService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->userProductService = new UserProductService();
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

            $dto = new CreateUserProductDTO($userId, $productId, $amount);

            $this->userProductService->create($dto);

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
