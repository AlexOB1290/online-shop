<body>
<div class="button">
    <button class="tablink" onclick="window.location='/catalog';">Каталог</button>
    <button class="tablink" onclick="window.location='/cart';">Корзина<span class="badge"><?php echo $count ?></span></button>
    <button class="tablink" onclick="window.location='/orders';">Заказы</button>
    <button class="tablink" onclick="window.location='/logout';">Выйти из аккаунта</button>
</div>

    <div id="main" class="main">
        <?php foreach ($products as $product) : ?>
            <div class="main_item">
                <div class="card" >
                    <img src="<?php echo $product->getImage()?>" alt="Carnaval Costumes" style="max-width:100%; height:auto">
                    <div class="container">
                        <h1><?php echo $product->getName()?></h1>
                        <p class="price"><?php echo $product->getPrice()?> руб.</p>
                        <p><?php echo $product->getDescription()?></p>
                        <form action="/add-product" method=POST>
                            <div class="container">
                                <label style="color: red;">
                                    <?php echo $errors['product-id']??"";?></label>
                                <input type="hidden" name="product-id" id="product-id" value="<?php echo $product->getId(); ?>" required>

                                <label for="amount"><b>Количество:</b></label>
                                <label style="color: red;">
                                    <?php echo $errors['amount']??"";?></label>
                                <input type="text" placeholder="Введите количество" name="amount" id="amount" required>
                                <button type="submit" class="cartbtn">Добавить в корзину</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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
        flex-wrap: nowrap;
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

<style>
    * {box-sizing: border-box}

    /* Bordered form */
    form {
        border: none;
    }

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Set a style for the submit/register button */
    .cartbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }
</style>