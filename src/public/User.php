<?php
class User
{
    private PDO $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }

    public function addNewUser($name, $email, $password): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

        $hash = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
    }

    public function getUserByEmail($email): mixed
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch();
    }

    public function getUserNameBySessionUserId($userId): mixed
    {
        $stmt = $this->pdo->prepare("SELECT name FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch();
    }
}