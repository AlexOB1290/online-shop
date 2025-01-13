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
    private ?float $avgRating = null;

    public static function getAllWithJoinByUserId(int $userId): ?array
    {
        $stmt = self::getPdo()->prepare("SELECT p.*, up.amount FROM products p JOIN user_products up ON p.id = up.product_id WHERE user_id = :user_id");
        $stmt->execute(["user_id" => $userId]);
        $data = $stmt->fetchAll();

        if($data === false) {
            return null;
        }

        $products = [];
        foreach ($data as $product) {
            $products[] = self::createObjectAut($product);
        }

        return $products;
    }

    public static function getAllWithJoinByOrderId(int $orderId): ?array
    {
        $stmt = self::getPdo()->prepare("SELECT p.name, p.image, op.amount, op.price FROM products p JOIN order_products op ON p.id = op.product_id WHERE order_id = :order_id");
        $stmt->execute(["order_id" => $orderId]);
        $data = $stmt->fetchAll();

        if($data === false) {
            return null;
        }

        $products = [];
        foreach ($data as $product) {
            $products[] = self::createObjectAut($product);
        }

        return $products;
    }

    public static function createObjectAut(array $data): self
    {
        $obj = new self();
        $arrayProp = get_class_vars(self::class);
        foreach ($arrayProp as $property => $value) {
            $propertyLower = strtolower($property);
            foreach ($data as $dataKey => $dataValue) {
                $key = strtolower(str_replace("_", "", $dataKey));
                if ($key === $propertyLower) {
                    $obj->$property = $dataValue;
                    break;
                }
            }
        }
        return $obj;
    }

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

    public function setAvgRating(float $avgRating): void
    {
        $this->avgRating = $avgRating;
    }

    public function getAvgRating(): float
    {
        return $this->avgRating;
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
