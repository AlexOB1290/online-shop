<form action="/order" method=POST>
    <div class="button">
        <button class="tablink" onclick="window.location='/catalog';">Каталог</button>
        <button class="tablink" onclick="window.location='/cart';">Корзина</button>
        <button class="tablink" onclick="window.location='/orders';">Заказы</button>
        <button class="tablink" onclick="window.location='/logout';">Выйти из аккаунта</button>
    </div>

    <div class="container">
        <br><br>
        <h1>Оформление заказа</h1>
        <p>Пожалуйста, заполните поля ниже, чтобы оформить заказ.</p>
        <hr>

        <label for="name"><b>Имя</b></label>
        <label style="color: red;">
            <?php echo $errors['name']??"";?></label>
        <input type="text" placeholder="Введите имя" name="name" id="name" value="<?php echo $userName ?? ""; ?>" required>

        <label for="email"><b>Email</b></label>
        <label style="color: red;">
            <?php echo $errors['email']??"";?></label>
        <input type="email" placeholder="Введите email" name="email" id="email" value="<?php echo $userEmail ?? ""; ?>" required>

        <label for="psw"><b>Адрес доставки</b></label>
        <label style="color: red;">
            <?php echo $errors['address']??"";?></label>
        <input type="text" placeholder="Введите адрес" name="address" id="address" required>

        <label for="telephone"><b>Номер телефона</b></label>
        <label style="color: red;">
            <?php echo $errors['telephone']??"";?></label>
        <input type="tel" placeholder="Введите номер телефона" name="telephone" id="telephone" required>
        <hr>

        <button type="submit" class="orderbtn">Оформить</button>

    </div>
    <div>
        <h2 style="margin-left: 10px"> <?php echo $str ?? ""?> </h2>
    </div>
    <div>
        <h3 style="margin-left: 10px">Список товаров из корзины:</h3>
    </div>

        <div id="main" class="main">
            <?php if (empty($products)) : ?>
            <?php echo "" ?>
            <?php else : ?>
            <?php foreach ($products as $product) : ?>
                <div class="main_item">
                    <div class="card" >
                        <img src="<?php echo $product->getImage()?>" alt="Carnaval Costumes" style="max-width:100%; height:auto">
                        <div class="container">
                            <h3><?php echo $product->getName()?></h3>
                            <p><?php echo $product->getPrice()?> руб.</p>
                            <p>Добавлено в корзину <?php echo $product->getAmount()?> ед. товара</p>
                            <p>Общая сумма: <?php echo $product->getTotal()?> руб.</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

</form>

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

    /* Add padding to containers */
    .container {
        padding: 16px;
        font-size: 12px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password], input[type=email], input[type=tel] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus input[type=email]:focus, input[type=tel]:focus{
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
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
        font-size: 22px;
    }

    .orderbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    .main
    {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        height: 10%;
        width: 10%;
    }

    .main_item
    {
        background: none;
        padding: 10px;
        margin-right: 5px;
    }

    .card img
    {
        height: 100%;
        width: 70%;
    }
</style>
