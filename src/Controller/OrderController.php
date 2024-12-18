<?php
namespace Controller;

use DTO\CreateOrderDTO;
use Model\User;
use Model\Product;
use Model\Order;
use Model\OrderProduct;
use Request\OrderRequest;
use Service\CartService;
use Service\OrderService;

class OrderController
{
    private User $userModel;
    private Order $orderModel;
    private Product $productModel;
    private OrderProduct $orderProductModel;
    private OrderService $orderService;
    private CartService $cartService;

    public function __construct()
    {
        $this->userModel = new User();
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->orderProductModel = new OrderProduct();
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
    }
    public function getOrderForm(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];

        $user = $this->userModel->getOneById($userId);

        $products = $this->cartService->getProducts($userId);

        $total = $this->cartService->getTotalAmountAndSum($userId);

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

            $dto = new CreateOrderDTO($userId, $orderNumber, $name, $email, $address, $telephone, $date);

            $this->orderService->create($dto);

            header('Location: /orders');
        } else {
            $userId = $_SESSION['user_id'];

            $user = $this->userModel->getOneById($userId);

            $products = $this->cartService->getProducts($userId);

            $total = $this->cartService->getTotalAmountAndSum($userId);

            require_once './../View/get_order.php';
        }
    }

    public function getOrders(): void
    {
        $this->checkSession();
        $userId = $_SESSION['user_id'];

        $obj = new CartService();
        $count = $obj->getCount($userId);

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
