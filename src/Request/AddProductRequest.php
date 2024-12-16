<?php

namespace Request;

use Model\Product;

class AddProductRequest extends Request
{
    public function getProductId(): ?int
    {
        return $this->data['product-id'] ?? null;
    }

    public function getAmount(): ?int
    {
        return $this->data['amount'] ?? null;
    }

    public function validate(): array
    {
        $errors = [];

        if(isset($this->data['product-id'])){
            $productId = $this->data['product-id'];

            if (empty($productId)) {
                $errors['product-id'] = "Product-id не должно быть пустым";
            } elseif ($productId < 1) {
                $errors['amount'] = "Product-id должно быть положительным числом";
            } elseif (!is_numeric($productId)) {
                $errors['product-id'] = "Product-id должно быть числом";
            } elseif (str_contains($productId, ".")) {
                $errors['product-id'] = "Product-id должно быть натуральным числом";
            } else {
                $product = new Product($productId);
                $product->getOneById($productId);

                if (!$product->getOneById($productId)) {
                    $errors['product-id'] = "Данный товар отсутствует в магазине";
                }
            }
        } else {
            $errors['name'] = "Требуется установить Product-id";
        }

        if(isset($this->data['amount'])){
            $amount = $this->data['amount'];

            if (empty($amount)) {
                $errors['amount'] = "Количество продуктов не должен быть пустым";
            } elseif ($amount < 1) {
                $errors['amount'] = "Количество продуктов должно быть положительным";
            } elseif (!is_numeric($amount)) {
                $errors['amount'] = "Количество продуктов должно быть числом";
            } elseif (str_contains($amount, ".")) {
                $errors['amount'] = "Количество должно быть натуральным числом";
            }
        } else {
            $errors['email'] = "Требуется установить Amount";
        }
        return $errors;
    }
}