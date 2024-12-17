<?php

namespace DTO;

class CreateOrderDTO
{
    public function __construct(
        private int $userId,
        private string $orderNumber,
        private string $name,
        private string $email,
        private string $address,
        private string $telephone,
        private string $date,
    ) {
        $this->userId = $userId;
        $this->orderNumber = $orderNumber;
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->telephone = $telephone;
        $this->date = $date;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }
}