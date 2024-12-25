<?php

namespace Service\Auth;

interface AuthServiceInterface
{
    public function check(): bool;
    public function getCurrentUser();
    public function login(string $login, string $password): bool;
    public function logout(): void;
}