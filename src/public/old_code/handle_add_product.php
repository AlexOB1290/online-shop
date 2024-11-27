<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
}


function validateAddProductForm(array $arrPost): array
{
    $errors = [];

    if(isset($arrPost['product-id'])){
        $productId = $arrPost['product-id'];
    } else {
        $errors['name'] = "Требуется установить Product-id";
    }

    if(isset($arrPost['amount'])){
        $amount = $arrPost['amount'];
    } else {
        $errors['email'] = "Требуется установить Amount";
    }

    if (empty($productId)) {
        $errors['product-id'] = "Product-id не должно быть пустым";
    } elseif ($productId < 1) {
        $errors['amount'] = "Product-id должно быть положительным числом";
    } elseif (!is_numeric($productId)) {
        $errors['product-id'] = "Product-id должно быть числом";
    } elseif (str_contains($productId, ".")) {
        $errors['product-id'] = "Product-id должно быть натуральным числом";
    } else {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT id FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $productData = $stmt->fetch();

        if ($productData === false) {
            $errors['product-id'] = "Данный товар отсутствует в магазине";
        }
    }

    if (empty($amount)) {
        $errors['amount'] = "Количество продуктов не должен быть пустым";
    } elseif ($amount < 1) {
        $errors['amount'] = "Количество продуктов должно быть положительным";
    } elseif (!is_numeric($amount)) {
        $errors['amount'] = "Количество продуктов должно быть числом";
    } elseif (str_contains($amount, ".")) {
        $errors['amount'] = "Количество должно быть натуральным числом";
    }

    return $errors;
}

$errors = validateAddProductForm($_POST);

if (empty($errors)) {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['product-id'];
    $amount = $_POST['amount'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    $userProductsData = $stmt->fetch();

    if ($userProductsData === false) {
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    } else {
        $stmt = $pdo->prepare("UPDATE user_products SET amount =amount + :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);
    }
}

require_once './get_add_product.php';