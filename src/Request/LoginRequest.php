<?php

namespace Request;

class LoginRequest extends Request
{
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

        if(isset($this->data['email'])){
            $email = $this->data['email'];
            if (empty($email)) {
                $errors['email'] = "Email не должен быть пустым";
            }
        } else {
            $errors['email'] = "Требуется установить Email";
        }

        if(isset($this->data['psw'])){
            $password = $this->data['psw'];
            if (empty($password)) {
                $errors['password'] = "Пароль не должен быть пустым";
            }
        } else {
            $errors['password'] = "Требуется установить Пароль";
        }

        return $errors;
    }
}