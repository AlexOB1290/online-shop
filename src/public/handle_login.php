<?php
function validateLoginForm(array $arrPost): array
{
    $errors = [];

    if(isset($arrPost['email'])){
        $email = $arrPost['email'];
    } else {
        $errors['email'] = "Требуется установить Email";
    }

    if(isset($arrPost['psw'])){
        $password = $arrPost['psw'];
    } else {
        $errors['password'] = "Требуется установить Пароль";
    }

    if (empty($email)) {
        $errors['email'] = "Email не должен быть пустым";
    } elseif (strlen($email) < 6) {
        $errors['email'] = "Email должен содержать не менее 6 символов";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email указан неверно";
    }

    if (empty($password)) {
        $errors['password'] = "Пароль не должен быть пустым";
    } elseif (strlen($password) < 4) {
        $errors['password'] = "Пароль должен содержать не менее 4 символов";
    } elseif (is_numeric($password)) {
        $errors['password'] = "Пароль не должен содержать только цифры";
    } elseif ($password === strtolower($password) || $password === strtoupper($password)) {
        $errors['password'] = "Пароль должен содержать заглавные и строчные буквы";
    }

    return $errors;
}


$errors = validateLoginForm($_POST);

if(empty($errors)) {
    $email = $_POST["email"];
    $password = $_POST["psw"];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $userData = $stmt->fetch();

    if($userData === false) {
        $errors['email'] = "Данный пользователь не зарегистрирован на сайте";
    } elseif (password_verify($password, $userData['password'])) {
        echo "Добро пожаловать на сайт!";
    } else {
        $errors['password'] = "Имя пользователя или пароль указаны неверно";
    }
}

require_once ('./get_login.php');