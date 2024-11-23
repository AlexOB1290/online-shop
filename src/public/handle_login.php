<?php
function validateLoginForm(array $arrPost): array
{
    $errors = [];

    if(isset($arrPost['email'])){
        $email = $arrPost['email'];
        if (empty($email)) {
            $errors['email'] = "Email не должен быть пустым";
        }
    } else {
        $errors['email'] = "Требуется установить Email";
    }

    if(isset($arrPost['psw'])){
        $password = $arrPost['psw'];
        if (empty($password)) {
            $errors['password'] = "Пароль не должен быть пустым";
        }
    } else {
        $errors['password'] = "Требуется установить Пароль";
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
        $errors['email'] = "Имя пользователя или пароль указаны неверно";
    } elseif (password_verify($password, $userData['password'])) {
        session_start();
        $_SESSION['user_id'] = $userData['id'];
        header('Location: /catalog');
    } else {
        $errors['email'] = "Имя пользователя или пароль указаны неверно";
    }
}

require_once ('./get_login.php');