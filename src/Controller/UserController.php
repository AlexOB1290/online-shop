<?php
namespace Controller;

use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController
{
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
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

            $newUser = $this->userModel->create($name, $email, $hashPassword);
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
            $email = $request->getEmail();
            $password = $request->getPassword();

            $user = $this->userModel->getOneByEmail($email);

            if(!$user) {
                $errors['email'] = "Имя пользователя или пароль указаны неверно";
            } elseif (password_verify($password, $user->getPassword())) {
                session_start();
                $_SESSION['user_id'] = $user->getId();
                header('Location: /catalog');
            } else {
                $errors['email'] = "Имя пользователя или пароль указаны неверно";
            }
        }
        require_once './../View/get_login.php';
    }

    public function logout(): void
    {
        session_start();
        $_SESSION = [];
        session_destroy();

        header('Location: /login');
    }
}
