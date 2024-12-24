<?php
namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private int $price;
    private string $description;
    private string $image;
    private ?int $amount = null;
    private ?int $total = null;

    public static function getAll(): ?array
    {
        $stmt = self::getPdo()->query("SELECT * FROM products ORDER BY id");
        $data = $stmt->fetchAll();

        if($data === false) {
            return null;
        }

        $products = [];
        foreach ($data as $product) {
            $products[] = self::createObject($product);
        }

        return $products;
    }

    public static function getOneById(int $productId): ?self
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $data = $stmt->fetch();

        if($data === false){
            return null;
        }

        return self::createObject($data);
    }

    public static function getAllByIds(array $productIds): ?array
    {
        $placeHolders = '?' . str_repeat(', ?', count($productIds) - 1);
        $stmt = self::getPdo()->prepare("SELECT * FROM products WHERE id IN ($placeHolders)");
        $stmt->execute($productIds);
        $data = $stmt->fetchAll();

        if($data === false) {
            return null;
        }

        $products = [];
        foreach ($data as $product) {
            $products[] = self::createObject($product);
        }

        return $products;
    }

    private static function createObject(array $data): self
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
