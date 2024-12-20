<?php

namespace Service;

use DTO\CreateOrderDTO;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderService
{
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }

    public function create(CreateOrderDTO $orderDTO): void
    {
        $userProducts = $this->getUserProducts($orderDTO->getUserId());

        $pdo = Model::getPdo();

        $pdo->beginTransaction();

        try {
            Order::create($orderDTO->getUserId(), $orderDTO->getOrderNumber(), $orderDTO->getName(), $orderDTO->getEmail(), $orderDTO->getAddress(), $orderDTO->getTelephone(), $this->userProductModel->getTotal(), $orderDTO->getDate());

            $order = Order::getOneByUserId($orderDTO->getUserId());

            OrderProduct::addUserProduct($order->getId(), $userProducts);

            UserProduct::deleteByUserId($orderDTO->getUserId());
        } catch (\PDOException $exception){
            $pdo->rollBack();

            throw $exception;
        }

        $pdo->commit();
    }

    private function getUserProducts(int $userId): array
    {
        $userProducts = UserProduct::getAllByUserId($userId);

        $productIds = [];
        foreach ($userProducts as $userProduct) {
            $productIds[] = $userProduct->getProductId();
        }

        $products = Product::getAllByIds($productIds);

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

        $this->userProductModel->setTotal($total);

        return $userProducts;
    }
}