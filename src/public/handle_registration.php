<?php
function validateRegistrationForm(array $arrPost): array
{
    $errors = [];

    if(isset($arrPost['name'])){
        $name = $arrPost['name'];
    } else {
        $errors['name'] = "Требуется установить Имя";
    }

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

    if(isset($arrPost['psw-repeat'])){
        $passwordRepeat = $arrPost['psw-repeat'];
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
    } else {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch();

        if ($userData !== false) {
            $errors['email'] = "Email уже зарегистрирован";
        }
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

$errors = validateRegistrationForm($_POST);

if(empty($errors)) {
    $name = $_POST['name'];
    $email = $_POST["email"];
    $password = $_POST['psw'];
    $passwordRepeat = $_POST['psw-repeat'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

//    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
//    $stmt->execute(['email' => $email]);
//
//    print_r($stmt->fetch());
}

require_once ('./get_registration.php');