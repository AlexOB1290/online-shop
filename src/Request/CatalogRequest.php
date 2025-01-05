<?php

namespace Request;

class CatalogRequest
{
    public function getProductId(): ?int
    {
        return $this->data['product-id'] ?? null;
    }
}