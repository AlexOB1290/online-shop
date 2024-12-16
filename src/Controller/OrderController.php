<?php
namespace Controller;

use Model\UserProduct;
use Model\User;
use Model\Product;
use Model\Order;
use Model\OrderProduct;
use Request\OrderRequest;

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

        $user = $this->userModel->getOneById($userId);

        $userProducts = $this->userProductModel->getAllByUserId($userId);

        if (!empty($userProducts)) {
            $productIds = [];
            foreach ($userProducts as $userProduct) {
                $productIds[] = $userProduct->getProductId();
            }

            $products = $this->productModel->getAllByIds($productIds);

            $totalSum = 0;
            $totalAmount = 0;

            foreach ($userProducts as $userProduct) {
                foreach ($products as &$product) {
                    if ($product->getId() === $userProduct->getProductId()) {
                        $product->setAmount($userProduct->getAmount());
                        $total = $product->getPrice() * $userProduct->getAmount();
                        $product->setTotal($total);
                        $totalSum += $total;
                        $totalAmount += $userProduct->getAmount();
                    }
                }
                unset($product);
            }
        }

        require_once './../View/get_order.php';
    }

    public function handleOrderForm(OrderRequest $request): void
    {
        $this->checkSession();
        $errors = $request->validate();

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $name = $request->getName();
            $email = $request->getEmail();
            $address = $request->getAddress();
            $telephone = $request->getTelephone();
            date_default_timezone_set('Asia/Irkutsk');
            $date = date('d-m-Y H:i:s');
            $prefix = date("is");
            $orderNumber = uniqid("$prefix-");

            $userProducts = $this->userProductModel->getAllByUserId($userId);

            if ($userProducts === false)
            $productIds = [];
            foreach ($userProducts as $userProduct) {
                $productIds[] = $userProduct->getProductId();
            }

            $products = $this->productModel->getAllByIds($productIds);

            $total = 0;
            foreach ($products as $product) {
                foreach ($userProducts as &$userProduct) {
                    if ($userProduct->getProductId() === $product->getId()) {
                        $userProduct->setPrice($product->getPrice());
                        $total += $product->getPrice() * $userProduct->getAmount();
                    }
                }
                unset($userProduct);
            }

            $this->orderModel->create($userId, $orderNumber, $name, $email, $address, $telephone, $total, $date);

            $order = $this->orderModel->getOneByUserId($userId);

            $this->orderProductModel->addUserProduct($order->getId(), $userProducts);

            $this->userProductModel->deleteByUserId($userId);

            header('Location: /orders');
        } else {
            $userId = $_SESSION['user_id'];
            $user = $this->userModel->getOneById($userId);
            $userProducts = $this->userProductModel->getAllByUserId($userId);

            if (!empty($userProducts)) {
                $productIds = [];
                foreach ($userProducts as $userProduct) {
                    $productIds[] = $userProduct->getProductId();
                }

                $products = $this->productModel->getAllByIds($productIds);

                $totalSum = 0;
                $totalAmount = 0;

                foreach ($userProducts as $userProduct) {
                    foreach ($products as &$product) {
                        if ($product->getId() === $userProduct->getProductId()) {
                            $product->setAmount($userProduct->getAmount());
                            $total = $product->getPrice() * $userProduct->getAmount();
                            $product->setTotal($total);
                            $totalSum += $total;
                            $totalAmount += $userProduct->getAmount();
                        }
                    }
                    unset($product);
                }
            }

            require_once './../View/get_order.php';
        }
    }

    public function getOrders(): void
    {
        $this->checkSession();
        $userId = $_SESSION['user_id'];

        $userProducts = $this->userProductModel->getAllByUserId($userId);

        if ($userProducts) {
            $amount = 0;

            foreach ($userProducts as $userProduct) {
                $amount += $userProduct->getAmount();
            }

            $count = $amount;
        }

        $orders = $this->orderModel->getAllByUserId($userId);

        foreach ($orders as &$order) {
            $order->setProducts($this->getOrderProducts($order->getId()));
        }
        unset($order);

        require_once './../View/orders.php';
    }

    private function getOrderProducts(int $orderId): array
    {
        $orderProducts = $this->orderProductModel->getByOrderId($orderId);

        $productIds = [];
        foreach ($orderProducts as $orderProduct) {
            $productIds[] = $orderProduct->getProductId();
        }

        $products = $this->productModel->getAllByIds($productIds);

        foreach ($orderProducts as $orderProduct) {
            foreach ($products as &$product) {
                if ($product->getId() === $orderProduct->getProductId()) {
                    $product->setAmount($orderProduct->getAmount());
                    $product->setPrice($orderProduct->getPrice());
                }
            }
            unset($product);
        }

        return $products;
    }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}
