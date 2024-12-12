<?php
namespace Controller;

use Model\UserProduct;
use Model\User;
use Model\Product;
use Model\Order;
use Model\OrderProduct;

class OrderController
{
    private User $userModel;
    private UserProduct $userProductModel;
    private Order $orderModel;
    private Product $productModel;
    private OrderProduct $orderProductModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->userProductModel = new UserProduct();
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->orderProductModel = new OrderProduct();
    }
    public function getOrderForm(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];
        $userData = $this->userModel->getOneById($userId);
        require_once './../View/get_order.php';
    }

    public function handleOrderForm(): void
    {
        $this->checkSession();
        $errors = $this->validateOrderForm($_POST);

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $telephone = $_POST['telephone'];
            date_default_timezone_set('Asia/Irkutsk');
            $date = date('d-m-Y H:i:s');
            $prefix = date("is");
            $orderNumber = uniqid("$prefix-");

            $userProducts = $this->userProductModel->getAllByUserId($userId);

            if ($userProducts === false)
            $productIds = [];
            foreach ($userProducts as $userProduct) {
                $productIds[] = $userProduct['product_id'];
            }

            $products = $this->productModel->getAllByIds($productIds);

            $total = 0;
            foreach ($products as $product) {
                foreach ($userProducts as &$userProduct) {
                    if ($userProduct['product_id'] === $product['id']) {
                        $userProduct['price'] = $product['price'];
                        $total += $userProduct['price'] * $userProduct['amount'];
                    }
                }
                unset($userProduct);
            }

            $this->orderModel->create($userId, $orderNumber, $name, $email, $address, $telephone, $total, $date);

            $userOrder = $this->orderModel->getOneByUserId($userId);

            $this->orderProductModel->addUserProduct($userOrder['id'], $userProducts);

            $this->userProductModel->deleteByUserId($userId);

            header('Location: /orders');
        } else {
            require_once './../View/get_order.php';
        }
    }

    public function getOrders(): void
    {
        $this->checkSession();
        $userId = $_SESSION['user_id'];
        $orders = $this->orderModel->getAllByUserId($userId);

        foreach ($orders as &$order) {
            $order['products'] = $this->getOrderProducts($order['id']);
        }
        unset($order);

        require_once './../View/orders.php';
    }

    private function getOrderProducts(int $orderId): array
    {
        $orderProducts = $this->orderProductModel->getByOrderId($orderId);

        $productIds = [];
        foreach ($orderProducts as $orderProduct) {
            $productIds[] = $orderProduct['product_id'];
        }

        $products = $this->productModel->getAllByIds($productIds);

        foreach ($orderProducts as $orderProduct) {
            foreach ($products as &$product) {
                if ($product['id'] === $orderProduct['product_id']) {
                    $product['order_amount'] = $orderProduct['amount'];
                    $product['order_price'] = $orderProduct['price'];
                }
            }
            unset($product);
        }

        return $products;
    }

    private function validateOrderForm(array $arrPost): array
    {
        $errors = [];

        if (isset($arrPost['name'])) {
            $name = $arrPost['name'];
        } else {
            $errors['name'] = "Требуется установить Имя";
        }

        if (isset($arrPost['email'])) {
            $email = $arrPost['email'];
        } else {
            $errors['email'] = "Требуется установить Email";
        }

        if (isset($arrPost['address'])) {
            $address = $arrPost['address'];
        } else {
            $errors['address'] = "Требуется установить Адрес";
        }

        if (isset($arrPost['telephone'])) {
            $telephone = $arrPost['telephone'];
        } else {
            $errors['telephone'] = "Требуется установить Номер телефона";
        }

        if (empty($name)) {
            $errors['name'] = "Имя не должно быть пустым";
        } elseif (is_numeric($name)) {
            $errors['name'] = "Имя не должно быть числом";
        } elseif (strlen($name) < 2) {
            $errors['name'] = "Имя должно содержать не менее 2 букв";
        }


        if (empty($email)) {
            $errors['email'] = "Email не должен быть пустым";
        } elseif (strlen($email) < 6) {
            $errors['email'] = "Email должен содержать не менее 6 символов";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email указан неверно";
        }

        if (empty($address)) {
            $errors['address'] = "Адрес не должен быть пустым";
        } elseif (strlen($address) < 4) {
            $errors['address'] = "Адрес должен содержать не менее 4 символов";
        } elseif (is_numeric($address)) {
            $errors['address'] = "Адрес не должен содержать только цифры";
        }

        if (empty($telephone)) {
            $errors['telephone'] = "Номер телефона не должен быть пустым";
        } elseif (!is_numeric($telephone)) {
            $errors['telephone'] = "Номер телефона должен содержать только цифры";
        } elseif (strlen($telephone) < 11 || strlen($telephone) > 11) {
            $errors['telephone'] = "Номер телефона должен содержать 11 цифр";
        }

        return $errors;
    }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}
