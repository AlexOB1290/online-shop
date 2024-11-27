<?php
require_once './UserProduct.php';
require_once './User.php';

class CartController
{
    private $userProductModel;
    private $userModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->userModel = new User();
    }

    public function getCartPage(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];

        $userData = $this->userModel->getUserNameBySessionUserId($userId);

        $userProducts = $this->userProductModel->getUserProductJoinProductByUserId($userId);

        if($userProducts === false) {
            echo "<p>Ошибка при загрузке данных в корзину</p>";
        } elseif (empty($userData)) {
            $errors = "Ошибка при отображении имени пользователя";
            require_once './cart.php';
        } else {
            require_once './cart.php';
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
