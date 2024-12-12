<div id="main" class="main">
    <?php foreach ($orders as $order) : ?>
        <div class="main_item">
            <div class="card" >
                <div class="container">
                    <h1>Заказ № <?php echo $order['order_number']?></h1>
                    <p>Имя заказчика: <?php echo $order['name']?></p>
                    <p>Адрес доставки: <?php echo $order['address']?></p>
                    <p class="price">Общая сумма <?php echo $order['total']?> руб.</p>
                    <p>Дата заказа: <?php echo $order['date']?></p>
                    <details class="details">
                        <summary>Список товаров</summary>
                        <div class="list">
                            <?php foreach ($order['products'] as $product) : ?>
                                <img src="<?php echo $product['image']?>" alt="Carnaval Costumes" style="max-width:20%; height:auto">
                                <p><?php echo "{$product['name']} - {$product['order_amount']} шт. Цена: {$product['price']}"?> руб. за ед.</p>
                            <?php endforeach; ?>
                        </div>

                    </details>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="container catalog">
    <p>Do you want to <a href="/catalog">Catalog</a>?</p>
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

    /* Set a grey background color and center the text of the "sign in" section */
    .logout {
        background-color: #f1f1f1;
        text-align: center;
    }

    .catalog {
        background-color: #04AA6D;
        text-align: center;
    }
</style>