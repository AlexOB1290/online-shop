<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
}

print_r($_POST);
print_r($_SESSION['user_id']);
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
    }

    if (empty($amount)) {
        $errors['amount'] = "Количество продуктов не должен быть пустым";
    } elseif ($amount < 1) {
        $errors['amount'] = "Количество продуктов должно быть положительным";
    } elseif (!is_numeric($amount)) {
        $errors['amount'] = "Количество продуктов должно быть числом";
    }

    return $errors;
}

print_r($errors = validateAddProductForm($_POST));

if (empty($errors)) {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['product-id'];
    $amount = $_POST['amount'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
}

require_once './get_add_product.php';