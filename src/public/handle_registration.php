<?php

function validateRegistrationForm(array $methodPost): array
{
    $errors = [];

    if(isset($methodPost['name'])){
        $name = $methodPost['name'];
    } else {
        $errors['name'] = "Требуется установить Имя";
    }

    if(isset($methodPost['email'])){
        $email = $methodPost['email'];
    } else {
        $errors['email'] = "Требуется установить Email";
    }

    if(isset($methodPost['psw'])){
        $password = $methodPost['psw'];
    } else {
        $errors['password'] = "Требуется установить Пароль";
    }

    if(isset($methodPost['psw-repeat'])){
        $passwordRepeat = $methodPost['psw-repeat'];
    } else {
        $errors['password-repeat'] = "Требуется установить повтор Пароля";
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

    if (empty($password)) {
        $errors['password'] = "Пароль не должен быть пустым";
    } elseif (strlen($password) < 4) {
        $errors['password'] = "Пароль должен содержать не менее 4 символов";
    } elseif (is_numeric($password)) {
        $errors['password'] = "Пароль не должен содержать только цифры";
    } elseif ($password === strtolower($password) || $password === strtoupper($password)) {
        $errors['password'] = "Пароль должен содержать заглавные и строчные буквы";
    } elseif ($password !== $passwordRepeat) {
        $errors['password'] = "Пароли не совпадают";
    }

    if (empty($passwordRepeat)) {
        $errors['password'] = "Повтор пароля не должен быть пустым";
    }

    return $errors;
}
//if(!preg_match("^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^", $password)) {
//    echo $error['password'] = "Пароль должен содержать заглавные, строчные буквы, цифры и спецсимволы: @$!%*#?&";
//} elseif ($password !== $passwordRepeat) {
//    echo $error['password'] = "Пароли не совпадают";
//}

$err = validateRegistrationForm($_POST);

if(empty($err)) {
    $name = $_POST['name'];
    $email = $_POST["email"];
    $password = $_POST['psw'];
    $passwordRepeat = $_POST['psw-repeat'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    print_r($stmt->fetch());
}

require_once ('./get_registration.php');