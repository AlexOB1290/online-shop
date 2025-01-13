<?php

namespace Service;

use DTO\CartDTO;
use Model\UserProduct;
use Model\Product;

class CartService
{
    public function create(CartDTO $cartDTO): void
    {
        $userProduct = UserProduct::getOneByIds($cartDTO->getUserId(), $cartDTO->getProductId());

        if (!$userProduct) {
            UserProduct::addProduct($cartDTO->getUserId(), $cartDTO->getProductId(), $cartDTO->getAmount());
        } else {
            UserProduct::increaseAmount($cartDTO->getAmount(), $cartDTO->getUserId(), $cartDTO->getProductId());
        }
    }

    public function addOne(CartDTO $cartDTO): void
    {
        UserProduct::increaseAmount($cartDTO->getAmount(), $cartDTO->getUserId(), $cartDTO->getProductId());
    }

    public function deleteOne(CartDTO $cartDTO): void
    {
        UserProduct::decreaseAmount($cartDTO->getAmount(), $cartDTO->getUserId(), $cartDTO->getProductId());
    }

    public function getUserProducts(int $userId): ?array
    {
        $products = Product::getAllWithJoinByUserId($userId);

        if ($products) {
            foreach ($products as &$product) {
                $total = $product->getPrice() * $product->getAmount();
                $product->setTotal($total);
            }
            unset($product);
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
            $count = 0;

            foreach ($userProducts as $userProduct) {
                $count += $userProduct->getAmount();
            }
        } else {
            return null;
        }

        return $count;
    }
}