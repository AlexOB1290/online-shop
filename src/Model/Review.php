<?php

namespace Model;

class Review extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $rating;
    private string $positive;
    private string $negative;
    private string $comment;
    private string $createdAt;
    private ?string $name = null;

    public static function getAllWithJoinByProductId(int $productId): ?array
    {
        $stmt = self::getPdo()->prepare("SELECT r.*, u.name FROM reviews r JOIN users u ON r.user_id = u.id WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $data = $stmt->fetchAll();

        if($data === false){
            return null;
        }

        $reviews = [];
        foreach($data as $order){
            $reviews[] = self::createObjectAut($order);
        }

        return $reviews;
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

    public static function create(int $userId, int $productId, int $rating, string $positive, string $negative, string $comment, string $createdAt): bool
    {
        $stmt = self::getPdo()->prepare("INSERT INTO reviews (user_id, product_id, rating, positive, negative, comment, created_at) VALUES (:user_id, :product_id, :rating, :positive, :negative, :comment, :created_at)");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'rating' => $rating, 'positive' => $positive, 'negative' => $negative, 'comment' => $comment, 'created_at' => $createdAt]);
    }

    public static function getAll(): ?array
    {
        $stmt = self::getPdo()->query("SELECT * FROM reviews");
        $data = $stmt->fetchAll();

        if($data === false) {
            return null;
        }

        $reviews = [];
        foreach ($data as $product) {
            $reviews[] = self::createObject($product);
        }

        return $reviews;
    }

    public static function getOneByUserIdAndProductId(int $userId, int $productId): ?self
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM reviews WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' =>$userId, 'product_id' => $productId]);
        $data = $stmt->fetch();

        if($data === false){
            return null;
        }

        return self::createObject($data);
    }

    public static function getAllByProductId(int $productId): ?array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM reviews WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $data = $stmt->fetchAll();

        if($data === false){
            return null;
        }

        $reviews = [];
        foreach($data as $order){
            $reviews[] = self::createObject($order);
        }

        return $reviews;
    }

    private static function createObject(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->rating = $data['rating'];
        $obj->positive = $data['positive'];
        $obj->negative = $data['negative'];
        $obj->comment = $data['comment'];
        $obj->createdAt = $data['created_at'];

        return $obj;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getPositive(): string
    {
        return $this->positive;
    }

    public function getNegative(): string
    {
        return $this->negative;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}