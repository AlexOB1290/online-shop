
    <div class="container">
        <h1>Корзина товаров пользователя <?php echo $userData['name']; ?></h1>

            <?php if (empty($products)) : ?>

            <p><?php echo "Ваша корзина пуста" ;?></p>

            <?php else : ?>
                <div id="main" class="main">
            <?php foreach ($products as $product) : ?>
                        <div class="main_item">
                            <div class="card" >
                                <img src="<?php echo $product['image']?>" alt="Carnaval Costumes" style="max-width:100%; height:auto">
                                <div class="container">
                                    <h1><?php echo $product['name']?></h1>
                                    <p class="price"><?php echo $product['price']?> руб.</p>
                                    <p><?php echo $product['description']?></p>
                                    <p>Добавлено в корзину <?php echo $product['amount']?> ед. товара</p>
                                    <p>Общая сумма: <?php echo $product['amount']*$product['price']?> руб.</p>
                                </div>
                            </div>
                        </div>
        <?php endforeach; ?>
                </div>
        <div>
            <button onclick="window.location='/order';" class="orderbtn">To order</button>
        </div>
        <?php endif; ?>

        <div class="container catalog">
    <p>Do you want to <a href="/catalog">Catalog</a>?</p>
        </div>
        <div class="container add">
            <p> Do you want to <a href="/add-product"> Add product</a>?</p>
        </div>
        <div class="container logout">
            <p>Do you want to log out of your account? <a href="/logout">Exit</a>.</p>
        </div>
    </div>



<style>

    * {box-sizing: border-box}

    /* Bordered form */
    form {
        border: 3px solid #f1f1f1;
    }

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

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

    /* Set a style for the submit/register button */
    .orderbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .orderbtn:hover {
        opacity:1;
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