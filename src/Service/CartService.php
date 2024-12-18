<?php

namespace Service;

use DTO\CartDTO;
use Model\UserProduct;
use Model\Product;

class CartService
{
    private UserProduct $userProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
    }

    public function create(CartDTO $userProductDTO): void
    {
        $userProduct = $this->userProductModel->getOneByIds($userProductDTO->getUserId(), $userProductDTO->getProductId());

        if (!$userProduct) {
            $this->userProductModel->addProduct($userProductDTO->getUserId(), $userProductDTO->getProductId(), $userProductDTO->getAmount());
        } else {
            $this->userProductModel->increaseAmount($userProductDTO->getAmount(), $userProductDTO->getUserId(), $userProductDTO->getProductId());
        }
    }

    public function getProducts(int $userId): array
    {
        $userProducts = $this->userProductModel->getAllByUserId($userId);

        if (!empty($userProducts)) {
            $productIds = [];
            foreach ($userProducts as $userProduct) {
                $productIds[] = $userProduct->getProductId();
            }

            $products = $this->productModel->getAllByIds($productIds);

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
        }

        return $products;
    }

    public function getCount(int $userId): ?int
    {
        $userProducts = $this->userProductModel->getAllByUserId($userId);

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