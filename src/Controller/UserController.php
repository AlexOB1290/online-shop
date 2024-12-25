<?php
namespace Controller;

use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Service\Auth\AuthServiceInterface;

class UserController
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    public function getRegistrationForm(): void
    {
        require_once './../View/get_registration.php';
    }

    public function handleRegistrationForm(RegistrateRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();

            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $newUser = User::create($name, $email, $hashPassword);
        }

        require_once './../View/get_registration.php';
    }

    public function getLoginForm(): void
    {
        require_once './../View/get_login.php';
    }

    public function handleLoginForm(LoginRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $login = $request->getEmail();
            $password = $request->getPassword();

            if ($this->authService->login($login, $password)) {
                header('Location: /catalog');
            } else {
                $errors = "Логин или пароль указаны неверно";
            }
        }
        require_once './../View/get_login.php';
    }
}
