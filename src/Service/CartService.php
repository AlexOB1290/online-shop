<?php

namespace Service;

use DTO\CartDTO;
use Model\UserProduct;
use Model\Product;

class CartService
{
    public function create(CartDTO $userProductDTO): void
    {
        $userProduct = UserProduct::getOneByIds($userProductDTO->getUserId(), $userProductDTO->getProductId());

        if (!$userProduct) {
            UserProduct::addProduct($userProductDTO->getUserId(), $userProductDTO->getProductId(), $userProductDTO->getAmount());
        } else {
            UserProduct::increaseAmount($userProductDTO->getAmount(), $userProductDTO->getUserId(), $userProductDTO->getProductId());
        }
    }

    public function getProducts(int $userId): ?array
    {
        $userProducts = UserProduct::getAllByUserId($userId);

        if (!empty($userProducts)) {
            $productIds = [];
            foreach ($userProducts as $userProduct) {
                $productIds[] = $userProduct->getProductId();
            }

            $products = Product::getAllByIds($productIds);

            foreach ($userProducts as $userProduct) {
                foreach ($products as &$product) {
                    if ($product->getId() === $userProduct->getProductId()) {
                        $product->setAmount($userProduct->getAmount());
                        $total = $product->getPrice() * $userProduct->getAmount();
                        $product->setTotal($total);
                    }
                }
                unset($product);
            }
        } else {
            return null;
        }

        return $products;
    }

    public function getTotalAmount(array $products): int
    {
        $totalAmount = 0;
        foreach ($products as $product) {
            $totalAmount += $product->getAmount();
        }

        return $totalAmount;
    }

    public function getTotalSum(array $products): int
    {
        $totalSum = 0;
        foreach ($products as $product) {
            $totalSum += $product->getTotal();
        }

        return $totalSum;
    }

    public function getCount(int $userId): ?int
    {
        $userProducts = UserProduct::getAllByUserId($userId);

        if ($userProducts) {
            $amount = 0;

            foreach ($userProducts as $userProduct) {
                $amount += $userProduct->getAmount();
            }

            $count = $amount;
        } else {
            return null;
        }

        return $count;
    }
}