<?php
namespace Controller;

use DTO\CreateOrderDTO;
use Model\Order;
use Model\Product;
use Request\OrderRequest;
use Service\Auth\AuthServiceInterface;
use Service\CartService;
use Service\OrderService;

class OrderController
{
    private AuthServiceInterface $authService;
    private CartService $cartService;
    private OrderService $orderService;
    public function __construct(AuthServiceInterface $authService, CartService $cartService, OrderService $orderService)
    {
        $this->authService = $authService;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }
    public function getOrderForm(): void
    {
        if(!$this->authService->check()){
            header('Location: /login');
            return;
        }

        $userId = $this->authService->getCurrentUser()->getId();

        $userName = $this->authService->getCurrentUser()->getName();
        $userEmail = $this->authService->getCurrentUser()->getEmail();

        $products = $this->cartService->getUserProducts($userId);

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

            $products = $this->cartService->getUserProducts($userId);

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
            return;
        }
        $userId = $this->authService->getCurrentUser()->getId();

        $count = $this->cartService->getCount($userId);

        $orders = Order::getAllByUserId($userId);

        foreach ($orders as &$order) {
            $order->setProducts(Product::getAllWithJoinByOrderId($order->getId()));
        }
        unset($order);

        require_once './../View/orders.php';
    }
}
