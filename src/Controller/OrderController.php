<?php
require_once './../Model/User.php';
require_once './../Model/UserProduct.php';

class OrderController
{
    private User $user;
    private UserProduct $userProduct;

    public function __construct()
    {
        $this->user = new User();
        $this->userProduct = new UserProduct();
    }
    public function getOderForm(): void
    {
        $this->checkSession();

        $userId = $_SESSION['user_id'];
        $userData = $this->user->getOneById($userId);
        require_once './../View/get_order.php';
    }

    public function handleOrderForm(): void
    {
        $this->checkSession();
        $errors = $this->validateOrderForm($_POST);

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $telephone = $_POST['telephone'];

            $userProducts = $this->userProduct->getAllByUserId($userId);
            print_r($userProducts);
        }

        require_once './../View/get_order.php';
    }

    private function validateOrderForm(array $arrPost): array
    {
        $errors = [];

        if (isset($arrPost['name'])) {
            $name = $arrPost['name'];
        } else {
            $errors['name'] = "Требуется установить Имя";
        }

        if (isset($arrPost['email'])) {
            $email = $arrPost['email'];
        } else {
            $errors['email'] = "Требуется установить Email";
        }

        if (isset($arrPost['address'])) {
            $address = $arrPost['address'];
        } else {
            $errors['address'] = "Требуется установить Адрес";
        }

        if (isset($arrPost['telephone'])) {
            $telephone = $arrPost['telephone'];
        } else {
            $errors['telephone'] = "Требуется установить Номер телефона";
        }

        if (empty($name)) {
            $errors['name'] = "Имя не должно быть пустым";
        } elseif (is_numeric($name)) {
            $errors['name'] = "Имя не должно быть числом";
        } elseif (strlen($name) < 2) {
            $errors['name'] = "Имя должно содержать не менее 2 букв";
        }


        if (empty($email)) {
            $errors['email'] = "Email не должен быть пустым";
        } elseif (strlen($email) < 6) {
            $errors['email'] = "Email должен содержать не менее 6 символов";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email указан неверно";
        }

        if (empty($address)) {
            $errors['address'] = "Адрес не должен быть пустым";
        } elseif (strlen($address) < 4) {
            $errors['address'] = "Адрес должен содержать не менее 4 символов";
        } elseif (is_numeric($address)) {
            $errors['address'] = "Адрес не должен содержать только цифры";
        }

        if (empty($telephone)) {
            $errors['telephone'] = "Номер телефона не должен быть пустым";
        } elseif (strlen($telephone) < 11) {
            $errors['telephone'] = "Номер телефона дожен содержать не менее 11 цифр";
        } elseif (!is_numeric($telephone)) {
            $errors['telephone'] = "Номер телефона должен содержать только цифры";
        }

        return $errors;
    }

    private function checkSession(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
    }
}
