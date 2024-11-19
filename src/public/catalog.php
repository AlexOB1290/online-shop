<?php
//if (!isset($_COOKIE['user_id'])) {
//    header('Location: /get_login.php');
//}

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /get_login.php');
} else {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->query("SELECT * FROM products");

    $productsData = $stmt->fetchAll();
}
?>


<div id="main" class="main">
    <?php foreach ($productsData as $product) : ?>
    <div class="main_item">
        <div class="card" >
            <img src="<?php echo $product['image']?>" alt="Carnaval Costumes" style="max-width:100%; height:auto">
            <div class="container">
                <h1><?php echo $product['name']?></h1>
                <p class="price"><?php echo $product['price']?> руб.</p>
                <p><?php echo $product['description']?></p>
                <p><button>Добавить в корзину</button></p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
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
</style>