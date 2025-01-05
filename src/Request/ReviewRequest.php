<?php

namespace Request;

class CatalogRequest extends Request
{
    public function getProductId(): ?int
    {
        return $this->data['product-id'] ?? null;
    }

    public function getRating(): ?int
    {
        return $this->data['rating'] ?? null;
    }

    public function getPositive(): ?string
    {
        return $this->data['positive'] ?? null;
    }

    public function getNegative(): ?string
    {
        return $this->data['negative'] ?? null;
    }

    public function getComment(): ?string
    {
        return $this->data['comment'] ?? null;
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['rating'])) {
            $rating = $this->data['rating'];

            if(empty($rating)) {
                $errors['rating'] = "Оценка не должна быть пустой";
            } elseif (!is_numeric($rating)) {
                $errors['rating'] = "Оценка должна быть цифрой и не равна нулю";
            } elseif ($rating < 1 && $rating > 5) {
                $errors['rating'] = "Оценка должна быть от 1 до 5";
            }
        } else {
            $errors['rating'] = "Требуется установить значение";
        }

        if (isset($this->data['positive'])) {
            $positive = $this->data['positive'];

            if(is_numeric($positive)) {
                $errors['positive'] = "Поле должно быть текстовым";
            } elseif (strlen($positive) < 4) {
                $errors['positive'] = "Текст должен содержать не менее 4 символов";
            }
        } else {
            $errors['positive'] = "Требуется установить значение";
        }

        if (isset($this->data['negative'])) {
            $negative = $this->data['negative'];

            if(is_numeric($negative)) {
                $errors['negative'] = "Поле должно быть текстовым";
            } elseif (strlen($negative) < 4) {
                $errors['negative'] = "Текст должен содержать не менее 4 символов";
            }
        } else {
            $errors['negative'] = "Требуется установить значение";
        }

        if (isset($this->data['comment'])) {
            $comment = $this->data['comment'];

            if(is_numeric($comment)) {
                $errors['comment'] = "Поле должно быть текстовым";
            } elseif (strlen($comment) < 4) {
                $errors['comment'] = "Текст должен содержать не менее 4 символов";
            }
        } else {
            $errors['comment'] = "Требуется установить значение";
        }

        return $errors;
    }
}