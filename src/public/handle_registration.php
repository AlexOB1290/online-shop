<?php

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['psw'];
$passwordRepeat = $_GET['psw-repeat'];

print_r("{$name} - {$email} - {$password} - {$passwordRepeat}");

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

$result = $pdo->query("SELECT * FROM users ORDER BY id DESC");

print_r($result->fetch());