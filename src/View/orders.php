<body>
<div class="button">
    <button class="tablink" onclick="window.location='/catalog';">Каталог</button>
    <button class="tablink" onclick="window.location='/cart';">Корзина<span class="badge"><?php echo $count ?? 0 ?></span></button>
    <button class="tablink" onclick="window.location='/orders';">Заказы</button>
    <button class="tablink" onclick="window.location='/logout';">Выйти из аккаунта</button>
</div>

    <div id="main" class="main">
        <?php if (empty($orders)) : ?>
            <p style="margin-left: 10px"><?php echo "Вы еще ничего не заказали" ;?></p>
        <?php else : ?>
        <?php foreach ($orders as $order) : ?>
            <div class="main_item">
                <div class="card" >
                    <div class="container">
                        <h1>Заказ № <?php echo $order->getOrderNumber()?></h1>
                        <p>Имя заказчика: <?php echo $order->getName()?></p>
                        <p>Адрес доставки: <?php echo $order->getAddress()?></p>
                        <p class="price">Общая сумма: <?php echo $order->getTotal()?> руб.</p>
                        <p>Дата заказа: <?php echo $order->getDate()?></p>
                        <details class="details">
                            <summary>Список товаров</summary>
                            <div class="list">
                                <?php foreach ($order->getProducts() as $product) : ?>
                                    <img src="<?php echo $product->getImage()?>" alt="Carnaval Costumes" style="max-width:20%; height:auto">
                                    <p><?php echo "{$product->getName()} - {$product->getAmount()} шт. Цена: {$product->getPrice()}"?> руб. за ед.</p>
                                <?php endforeach; ?>
                            </div>

                        </details>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

<style>
    /* Set height of body and the document to 100% to enable "full page tabs" */
    body, html {
        height: 100%;
        margin: 0;
        font-family: Arial;
    }

    .button {
        position: fixed;
        width: 100%;
    }

    /* Style tab links */
    .tablink {
        background-color: #555;
        color: white;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        font-size: 17px;
        width: 25%;
    }

    .tablink:hover {
        background-color: #04AA6D;
    }

    .tablink .badge {
        position: absolute;
        top: 17%;
        right: 57%;
        padding: 5px 10px;
        border-radius: 50%;
        background: red;
        color: white;
    }
</style>

<style>
    .main
    {
        display: inline-flex;
        flex-direction: row;
        flex-wrap: wrap;
        margin-top: 50px;
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

    .details {
        border: none;
        outline: 0;
        padding: 12px;
        color: white;
        background-color: #04AA6D;
        text-align: center;
        cursor: pointer;
        width: auto;
        font-size: 18px;
        margin-bottom: 18px;
    }

    .details:hover {
        opacity: 0.7;
    }
</style>