<?php

namespace Service;

use Model\User;

class AuthService
{
    public function check(): bool
    {
        $this->startSession();

        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->check()) {
            return null;
        }

        $this->startSession();

        $userId = $_SESSION['user_id'];

        return User::getOneById($userId);
    }

    public function login(string $login, string $password): bool
    {
        $user = User::getOneByEmail($login);

        if(!$user) {
            return false;
        } elseif (password_verify($password, $user->getPassword())) {
            session_start();
            $_SESSION['user_id'] = $user->getId();
            return true;
        } else {
            return false;
        }
    }

    public function logout(): void
    {
        session_start();
        $_SESSION = [];
        session_destroy();

        header('Location: /login');
    }

    private function startSession(): void
    {
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
    }
}