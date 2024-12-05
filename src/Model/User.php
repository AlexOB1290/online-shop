<?php
require_once './../Model/PdoConnection.php';
class User extends PdoConnection
{
    public function create(string $name, string $email, string $hashPassword): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashPassword]);
    }

    public function getOneByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getOneById(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch();
    }
}