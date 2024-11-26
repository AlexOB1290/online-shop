<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
} else {
    $userId = $_SESSION['user_id'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT amount, name, price, description, image FROM products JOIN user_products ON user_products.product_id = products.id WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $userProductsData = $stmt->fetchAll();

//    $stmt = $pdo->prepare("SELECT product_id, amount FROM user_products WHERE user_id = :user_id");
//    $stmt->execute(['user_id' => $userId]);
//    print_r($userProductsData = $stmt->fetchAll());
//
//    foreach ($userProductsData as $userProduct) {
//        $productId = $userProduct['product_id'];
//        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
//        $stmt->execute(['id' => $productId]);
//        print_r($userProductsData[] = $stmt->fetch());
//    }

    $stmt = $pdo->prepare("SELECT name FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    $userData = $stmt->fetch();

    if ($userProductsData === false) {
        $error = "Ошибка при выдаче данных товаров корзины";
    } elseif ($userData === false) {
        $error = "Ошибка при выдаче имени пользователя";
    }
}
?>

<h1>Корзина товаров пользователя <?php echo $userData['name'] ?? $error?></h1>
<div id="main" class="main">
    <?php foreach ($userProductsData as $product) : ?>
        <div class="main_item">
            <div class="card" >
                <img src="<?php echo $product['image']?>" alt="Carnaval Costumes" style="max-width:100%; height:auto">
                <div class="container">
                    <h1><?php echo $product['name']?></h1>
                    <p class="price"><?php echo $product['price']?> руб.</p>
                    <p><?php echo $product['description']?></p>
                    <p>Добавлено в корзину <?php echo $product['amount']?> ед. товара</p>
                    <p>Общая сумма: <?php echo $product['amount']*$product['price']?> руб.</p>

                    <p><button>Купить</button></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="container catalog">
    <p>Do you want to <a href="/catalog">Catalog</a>?</p>
</div>
<div class="container add">
    <p> Do you want to <a href="/add-product"> Add product</a>?</p>
</div>
<div class="container logout">
    <p>Do you want to log out of your account? <a href="/logout">Exit</a>.</p>
</div>



<style>
    .main
    {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
    }

    .main_item
    {
        background: none;
        padding: 10px;
        margin-right: 5px;
    }
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: auto;
        text-align: center;
        font-family: arial;
    }

    /* Some left and right padding inside the container */
    .container {
        padding: 0 16px;
    }

    /* Clear floats */
    .container::after, .row::after {
        content: "";
        clear: both;
        display: table;
    }

    .price {
        color: grey;
        font-size: 22px;
    }

    .card button {
        border: none;
        outline: 0;
        padding: 12px;
        color: white;
        background-color: #04AA6D;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
    }

    .card button:hover {
        opacity: 0.7;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .logout {
        background-color: #f1f1f1;
        text-align: center;
    }

    .catalog {
        background-color: #04AA6D;
        text-align: center;
    }

    .add {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>