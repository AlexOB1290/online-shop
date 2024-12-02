<?php
require_once './../Model/UserProduct.php';
require_once './../Model/User.php';
require_once './../Model/Product.php';

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

        $productIds = [];
        foreach ($userProducts as $userProduct) {
            $productIds[] = $userProduct['product_id'];
        }

        $productsDB = $this->productModel->getAllByIds($productIds);

        $products = [];
        $i = 0;
        foreach ($userProducts as $userProduct) {
            $products[$i] = $productsDB[$i];
            $products[$i]['amount'] = $userProduct['amount'];
            $i++;
        }

//        $products = [];
//
//        foreach ($userProducts as $userProduct) {
//            $productId = $userProduct['product_id'];
//            $product = $this->productModel->getOneById($productId);
//            $product['amount'] = $userProduct['amount'];
//            $products[] = $product;
//        }

        require_once './../View/cart.php';

//        $products = $this->productModel->getAllWithAmountInCart($userId);
//
//        if($products === false) {
//            echo "<p>Ошибка при загрузке данных в корзину</p>";
//        } elseif (empty($userData)) {
//            $errors = "Ошибка при отображении имени пользователя";
//            require_once './../View/cart.php';
//        } else {
//            require_once './../View/cart.php';
//        }
    }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}
