<?php

namespace Service;

use DTO\CreateOrderDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderService
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private Product $productModel;
    private OrderProduct $orderProductModel;
    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->orderProductModel = new OrderProduct();
    }

    public function create(CreateOrderDTO $orderDTO): void
    {
        $userProducts = $this->userProductModel->getAllByUserId($orderDTO->getUserId());

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

            $this->orderModel->create($orderDTO->getUserId(), $orderDTO->getOrderNumber(), $orderDTO->getName(), $orderDTO->getEmail(), $orderDTO->getAddress(), $orderDTO->getTelephone(), $total, $orderDTO->getDate());

            $order = $this->orderModel->getOneByUserId($orderDTO->getUserId());

            $this->orderProductModel->addUserProduct($order->getId(), $userProducts);

            $this->userProductModel->deleteByUserId($orderDTO->getUserId());
    }
}