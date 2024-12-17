<?php

namespace Service;

use DTO\CreateUserProductDTO;
use Model\UserProduct;

class UserProductService
{
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }

    public function create(CreateUserProductDTO $userProductDTO): void
    {
        $userProduct = $this->userProductModel->getOneByIds($userProductDTO->getUserId(), $userProductDTO->getProductId());

        if (!$userProduct) {
            $this->userProductModel->addProduct($userProductDTO->getUserId(), $userProductDTO->getProductId(), $userProductDTO->getAmount());
        } else {
            $this->userProductModel->increaseAmount($userProductDTO->getAmount(), $userProductDTO->getUserId(), $userProductDTO->getProductId());
        }
    }
}