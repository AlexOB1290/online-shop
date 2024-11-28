<?php
class User
{
    private PDO $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }

    public function addNewUser(string $name, string $email, string $hashPassword): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashPassword]);
    }

    public function getUserByEmail(string $email): mixed
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getUserNameBySessionUserId(string $userId): mixed
    {
        $stmt = $this->pdo->prepare("SELECT name FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch();
    }
}