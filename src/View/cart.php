<body>
<div class="button">
    <button class="tablink" onclick="window.location='/catalog';">Каталог</button>
    <button class="tablink" onclick="window.location='/cart';" id="defaultOpen">Корзина</button>
    <button class="tablink" onclick="window.location='/orders';">Заказы</button>
    <button class="tablink" onclick="window.location='/logout';">Выйти из аккаунта</button>
</div>

    <div class="container">
        <br><br>

        <?php if (empty($products)) : ?>

            <p style="margin-left: 10px"><?php echo "Ваша корзина пуста" ;?></p>

        <?php else : ?>
            <h2 style="margin-left: 10px">Всего <?php echo $totalAmount ?? "" ?> ед. товара на сумму <?php echo $totalSum ?? "" ?> руб.</h2>
            <div id="main" class="main">
                <?php foreach ($products as $product) : ?>
                    <div class="main_item">
                        <div class="card" >
                            <img src="<?php echo $product->getImage()?>" alt="Carnaval Costumes" style="max-width:100%; height:auto">
                            <div class="container">
                                <h2><?php echo $product->getName()?></h2>
                                <p class="price"><?php echo $product->getPrice()?> руб.</p>
                                <p><?php echo $product->getDescription()?></p>
                                <p>Добавлено в корзину <?php echo $product->getAmount()?> ед. товара</p>
                                <p>Общая сумма: <?php echo $product->getTotal()?> руб.</p>
                                <div class="deladd">
                                    <form class="delete" onsubmit="return false" method="POST">
                                        <button type="submit" class="deltbtn">-</button>
                                        <input type="hidden" name="product-id" id="product-id" value="<?php echo $product->getId(); ?>" required>
                                        <input type="hidden" name="amount" id="amount" value="1" required>
                                    </form>
                                        <label for="amount"></label>
                                        <label style="color: red;">
                                            <?php echo $errors['amount']??"";?></label>
                                        <input class="amount" type="text" placeholder="Введите количество" name="amount" id="amount" value="<?php echo $product->getAmount()?>" required>
                                    <form class="add" onsubmit="return false" method="POST">
                                        <button type="submit" class="addbtn">+</button>
                                        <input type="hidden" name="product-id" id="product-id" value="<?php echo $product->getId(); ?>" required>
                                        <input type="hidden" name="amount" id="amount" value="1" required>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div>
                <button onclick="window.location='/order';" class="orderbtn">Оформить заказ</button>
                <button onclick="window.location='/clear-cart';" class="clearbtn">Очистить корзину</button>
            </div>
        <?php endif; ?>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    var form = $('.delete');
    console.log(form);

    $("document").ready(function () {
        form.submit(function () {
            $.ajax({
                global: false,
                type: "POST",
                url: "/delete",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('.amount').val(data.amount);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении товара:', error);
                }
            });
        });
    });
</script>

<script>
    var form = $('.add');
    console.log(form);

    $("document").ready(function () {
        form.submit(function () {
            $.ajax({
                global: false,
                type: "POST",
                url: "/add",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('.amount').val(data.amount);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении товара:', error);
                }
            });
        });
    });
</script>

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
</style>

<style>
    * {box-sizing: border-box}

    /* Bordered form */
    form {
        border: none;
        float: left;
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
        float: left;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 50%;
        opacity: 0.9;
        font-size: 22px;
    }

    .orderbtn:hover {
        opacity:1;
    }

    .clearbtn {
        background-color: dodgerblue;
        color: white;
        float: left;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 50%;
        opacity: 0.9;
        font-size: 22px;
    }

    .clearbtn:hover {
        opacity:1;
    }

    .deladd {
        float: none;
        width: 100%;
        display: flex;
        text-align: center;
    }

    .cartbtn {
        font-size: 17px;
        padding: 5px 6px;
        cursor: pointer;
    }

    input[type=text] {
        width: 100%;
        flex-grow: 1;
        border: none;
        text-align: center;
    }
</style>