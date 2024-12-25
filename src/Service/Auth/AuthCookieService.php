<?php

namespace Service\Auth;

use Model\User;

class AuthCookieService implements AuthServiceInterface
{
    public function check(): bool
    {
        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->check()) {
            return null;
        }

        $userId = $_COOKIE['user_id'];

        return User::getOneById($userId);
    }

    public function login(string $login, string $password): bool
    {
        $user = User::getOneByEmail($login);

        if(!$user) {
            return false;
        } elseif (password_verify($password, $user->getPassword())) {
            setcookie('user_id', $user->getId());
            return true;
        } else {
            return false;
        }
    }

    public function logout(): void
    {
        setcookie('user_id', null);

        header('Location: /login');
    }
}