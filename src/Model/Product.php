<?php
namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private int $price;
    private string $description;
    private string $image;
    private int $amount = 0;
    private int $total = 0;

    public function getAll(): ?array
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY id");
        $data = $stmt->fetchAll();

        if($data === false) {
            return null;
        }

        $products = [];
        foreach ($data as $product) {
            $products[] = $this->createObject($product);
        }

        return $products;
    }

    public function getOneById(int $productId): ?self
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $data = $stmt->fetch();

        if($data === false){
            return null;
        }

        return $this->createObject($data);
    }

    public function getAllByIds(array $productIds): ?array
    {
        $placeHolders = '?' . str_repeat(', ?', count($productIds) - 1);
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id IN ($placeHolders)");
        $stmt->execute($productIds);
        $data = $stmt->fetchAll();

        if($data === false) {
            return null;
        }

        $products = [];
        foreach ($data as $product) {
            $products[] = $this->createObject($product);
        }

        return $products;
    }

    private function createObject(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->price = $data['price'];
        $obj->description = $data['description'];
        $obj->image = $data['image'];

        return $obj;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
    public function getTotal(): int
    {
        return $this->total;
    }
}
