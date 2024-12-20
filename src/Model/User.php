<?php
namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public static function create(string $name, string $email, string $hashPassword): bool
    {
        $stmt = self::getPdo()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashPassword]);
    }

    public static function getOneByEmail(string $email): ?self
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        if($data === false) {
            return null;
        }

        return self::createObject($data);
    }

    public static function getOneById(int $userId): ?self
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $data = $stmt->fetch();

        if($data === false) {
            return null;
        }

        return self::createObject($data);
    }

    private static function createObject (array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}