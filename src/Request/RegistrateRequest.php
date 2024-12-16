<?php

namespace Request;

use Model\User;

class RegistrateRequest extends Request
{
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function getEmail(): ?string
    {
        return $this->data['email'] ?? null;
    }

    public function getPassword(): ?string
    {
        return $this->data['psw'] ?? null;
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];

            if (empty($name)) {
                $errors['name'] = "не должно быть пустым";
            } elseif (is_numeric($name)) {
                $errors['name'] = "не должно быть числом";
            } elseif (strlen($name) < 2) {
                $errors['name'] = "должно содержать не менее 2 букв";
            }
        } else {
            $errors['name'] = "Требуется установить Имя";
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];

            if (empty($email)) {
                $errors['email'] = "не должен быть пустым";
            } elseif (strlen($email) < 6) {
                $errors['email'] = "должен содержать не менее 6 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "указан неверно";
            } else {
                $user = new User();

                if ($user->getOneByEmail($email)) {
                    $errors['email'] = "уже зарегистрирован";
                }
            }
        } else {
            $errors['email'] = "Требуется установить Email";
        }

        if (isset($this->data['psw-repeat'])) {
            $passwordRepeat = $this->data['psw-repeat'];

            if (empty($passwordRepeat)) {
                $errors['password'] = "Повтор пароля не должен быть пустым";
            }
        } else {
            $errors['password-repeat'] = "Требуется установить повтор Пароля";
        }

        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];

            if (empty($password)) {
                $errors['password'] = "не должен быть пустым";
            } elseif (strlen($password) < 4) {
                $errors['password'] = "должен содержать не менее 4 символов";
            } elseif (is_numeric($password)) {
                $errors['password'] = "не должен содержать только цифры";
            } elseif ($password === strtolower($password) || $password === strtoupper($password)) {
                $errors['password'] = "должен содержать заглавные и строчные буквы";
            } elseif ($password !== $passwordRepeat) {
                $errors['password'] = "не совпадает с повтором пароля";
            }
        } else {
            $errors['password'] = "Требуется установить Пароль";
        }

        return $errors;
    }
}