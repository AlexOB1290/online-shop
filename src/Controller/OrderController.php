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
use Service\AuthService;

class OrderController
{
    private OrderService $orderService;
    private CartService $cartService;
    private AuthService $authService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->authService = new AuthService();
    }
    public function getOrderForm(): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
        }

        $userId = $this->authService->getCurrentUser()->getId();

        $userName = $this->authService->getCurrentUser()->getName();
        $userEmail = $this->authService->getCurrentUser()->getEmail();

        $products = $this->cartService->getProducts($userId);

        if(isset($products)) {
            $totalAmount = $this->cartService->getTotalAmount($products);
            $totalSum = $this->cartService->getTotalSum($products);
            $str = "Всего $totalAmount ед. товара на сумму $totalSum руб.";
        }

        require_once './../View/get_order.php';
    }

    public function handleOrderForm(OrderRequest $request): void
    {
        $userId = $this->authService->getCurrentUser()->getId();

        $errors = $request->validate();

        if (empty($errors)) {

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
            $userName = $this->authService->getCurrentUser()->getName();
            $userEmail = $this->authService->getCurrentUser()->getEmail();

            $products = $this->cartService->getProducts($userId);

            if(isset($products)) {
                $totalAmount = $this->cartService->getTotalAmount($products);
                $totalSum = $this->cartService->getTotalSum($products);
                $str = "Всего {$totalAmount} ед. товара на сумму echo {$totalSum} руб.";
            }

            require_once './../View/get_order.php';
        }
    }

    public function getOrders(): void
    {
        if(!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getCurrentUser()->getId();

        $count = $this->cartService->getCount($userId);

        $orders = Order::getAllByUserId($userId);

        foreach ($orders as &$order) {
            $order->setProducts($this->getOrderProducts($order->getId()));
        }
        unset($order);

        require_once './../View/orders.php';
    }

    private function getOrderProducts(int $orderId): array
    {
        $orderProducts = OrderProduct::getByOrderId($orderId);

        $productIds = [];
        foreach ($orderProducts as $orderProduct) {
            $productIds[] = $orderProduct->getProductId();
        }

        $products = Product::getAllByIds($productIds);

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
}
