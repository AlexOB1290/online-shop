<?php

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['psw'];
$passwordRepeat = $_POST['psw-repeat'];

$error = [];

//print_r("{$name} - {$email} - {$password} - {$passwordRepeat}");

if(empty($name)) {
    echo $error['name'] = "Имя не должно быть пустым";
} elseif(is_numeric($name)) {
    echo $error['name'] = "Имя не должно быть числом";
} elseif (strlen($name) < 2) {
    echo $error['name'] = "Имя должно содержать не менее 2 букв";
}

if(empty($email)) {
    echo $error['email'] = "Email не должен быть пустым";
} elseif(strlen($email) < 6) {
    echo $error['email'] = "Email должен содержать не менее 6 символов";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo $error['email'] = "Email указан неверно";
}

if(empty($password)) {
    echo $error['password'] = "Пароль не должен быть пустым";
} elseif(strlen($password) < 4) {
    echo $error['password'] = "Пароль должен содержать не менее 4 символов";
} elseif (is_numeric($password)) {
    echo $error['password'] = "Пароль не должен содержать только цифры";
} elseif ($password === strtolower($password) || $password === strtoupper($password)) {
    echo $error['password'] = "Пароль должен содержать заглавные и строчные буквы";
} elseif ($password !== $passwordRepeat) {
    echo $error['password'] = "Пароли не совпадают";
}

if(empty($error)) {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    print_r($stmt->fetch());
}
