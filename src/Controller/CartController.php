<?php
namespace Controller;
use Model\UserProduct;
use Model\User;
use Model\Product;
class CartController
{
    private UserProduct $userProductModel;
    private User $userModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->userModel = new User();
        $this->productModel = new Product();
    }

    public function getCartPage(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];

        $userData = $this->userModel->getOneById($userId);

        $userProducts = $this->userProductModel->getAllByUserId($userId);

        if (!empty($userProducts)) {
            $productIds = [];
            foreach ($userProducts as $userProduct) {
                $productIds[] = $userProduct['product_id'];
            }

            $products = $this->productModel->getAllByIds($productIds);

            foreach ($userProducts as $userProduct) {
                foreach ($products as &$product) {
                    if ($product['id'] === $userProduct['product_id']) {
                        $product['amount'] = $userProduct['amount'];
                    }
                }
                unset($product);
            }
        }


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
