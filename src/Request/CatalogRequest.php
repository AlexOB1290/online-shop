<?php

namespace Request;

class CatalogRequest extends Request
{
    public function getProductId(): ?int
    {
        return $this->data['product-id'] ?? null;
    }
}