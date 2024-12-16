<?php

namespace Request;

class OrderRequest extends Request
{
    public function getName(): ?string
    {
        return $this->data['name'];
    }

    public function getEmail(): ?string
    {
        return $this->data['email'];
    }

    public function getAddress(): ?string
    {
        return $this->data['address'];
    }

    public function getTelephone(): ?string
    {
        return $this->data['telephone'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];

            if (empty($name)) {
                $errors['name'] = "Имя не должно быть пустым";
            } elseif (is_numeric($name)) {
                $errors['name'] = "Имя не должно быть числом";
            } elseif (strlen($name) < 2) {
                $errors['name'] = "Имя должно содержать не менее 2 букв";
            }
        } else {
            $errors['name'] = "Требуется установить Имя";
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];

            if (empty($email)) {
                $errors['email'] = "Email не должен быть пустым";
            } elseif (strlen($email) < 6) {
                $errors['email'] = "Email должен содержать не менее 6 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email указан неверно";
            }
        } else {
            $errors['email'] = "Требуется установить Email";
        }

        if (isset($this->data['address'])) {
            $address = $this->data['address'];

            if (empty($address)) {
                $errors['address'] = "Адрес не должен быть пустым";
            } elseif (strlen($address) < 4) {
                $errors['address'] = "Адрес должен содержать не менее 4 символов";
            } elseif (is_numeric($address)) {
                $errors['address'] = "Адрес не должен содержать только цифры";
            }
        } else {
            $errors['address'] = "Требуется установить Адрес";
        }

        if (isset($this->data['telephone'])) {
            $telephone = $this->data['telephone'];

            if (empty($telephone)) {
                $errors['telephone'] = "Номер телефона не должен быть пустым";
            } elseif (!is_numeric($telephone)) {
                $errors['telephone'] = "Номер телефона должен содержать только цифры";
            } elseif (strlen($telephone) < 11 || strlen($telephone) > 11) {
                $errors['telephone'] = "Номер телефона должен содержать 11 цифр";
            }
        } else {
            $errors['telephone'] = "Требуется установить Номер телефона";
        }

        return $errors;
    }
}