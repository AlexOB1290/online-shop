<?php
namespace Model;

class Order extends Model
{
    private int $id;
    private int $userId;
    private string $orderNumber;
    private string $name;
    private string $email;
    private string $address;
    private string $telephone;
    private string $total;
    private string $date;

    private array $products = [];
    public function create(int $userId, string $orderNumber, string $name, string $email, string $address, string $telephone, string $total, string $date): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, order_number, name, email, address, telephone, total, date) VALUES (:user_id, :order_number, :name, :email, :address, :telephone, :total, :date)");
        return $stmt->execute(['user_id' => $userId, 'name' => $name, 'order_number'=>$orderNumber, 'email' => $email, 'address' => $address, 'telephone' => $telephone, 'total' => $total, 'date' => $date]);
    }

    public function getAllByUserId(int $userId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchAll();

        if($data === false){
            return null;
        }

        $orders = [];
        foreach($data as $order){
            $obj = new self();
            $obj->id = $order['id'];
            $obj->userId = $order['user_id'];
            $obj->orderNumber = $order['order_number'];
            $obj->name = $order['name'];
            $obj->email = $order['email'];
            $obj->address = $order['address'];
            $obj->telephone = $order['telephone'];
            $obj->total = $order['total'];
            $obj->date = $order['date'];

            $orders[] = $obj;
        }

        return $orders;
    }

    public function getOneByUserId(int $userId): ?self
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->orderNumber = $data['order_number'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->address = $data['address'];
        $obj->telephone = $data['telephone'];
        $obj->total = $data['total'];
        $obj->date = $data['date'];

        return $obj;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
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

    public function getTotal(): string
    {
        return $this->total;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}