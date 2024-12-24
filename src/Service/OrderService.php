<?php

namespace Service;

use DTO\CreateOrderDTO;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Service\CartService;

class OrderService
{
    private CartService $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }
    public function create(CreateOrderDTO $orderDTO): void
    {
        $userProducts = $this->cartService->getUserProducts($orderDTO->getUserId());

        if ($userProducts) {
            $pdo = Model::getPdo();

            $pdo->beginTransaction();

            try {
                Order::create($orderDTO->getUserId(), $orderDTO->getOrderNumber(), $orderDTO->getName(), $orderDTO->getEmail(), $orderDTO->getAddress(), $orderDTO->getTelephone(), $this->cartService->getTotalSum($userProducts), $orderDTO->getDate());

                $order = Order::getOneByUserId($orderDTO->getUserId());

                OrderProduct::addUserProduct($order->getId(), $userProducts);

                UserProduct::deleteByUserId($orderDTO->getUserId());
            } catch (\PDOException $exception){
                $pdo->rollBack();

                throw $exception;
            }

            $pdo->commit();
        }
    }
}