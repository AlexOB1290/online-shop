
<body>
<div class="button">
    <button class="tablink" onclick="window.location='/catalog';">Каталог</button>
    <button class="tablink" onclick="window.location='/cart';">Корзина<span class="badge"><?php echo $count ?? 0 ?></span></button>
    <button class="tablink" onclick="window.location='/orders';">Заказы</button>
    <button class="tablink" onclick="window.location='/logout';">Выйти из аккаунта</button>
</div>
<div class="container">
    <div class="header" style="text-align:center">
        <h2>Карточка товара</h2>
        <p>Уважаемый покупатель, не забудьте оставить отзыв о товаре</p>
    </div>
    <div class="row">
        <div class="column">
            <img src="<?php echo $product->getImage()?>" style="width:30%">
        </div>
        <div class="column">
            <h3><?php echo $product->getName()?></h3>
            <p class="price">Стоимость <?php echo $product->getPrice()?> руб.</p>
            <p><?php echo $product->getDescription()?></p>
            <form action="/review" method=POST>
                    <input type="hidden" name="product-id" id="product-id" value="<?php echo $product->getId(); ?>" required>
                    <button type="submit" class="descbtn">Оставить отзыв</button>
            </form>
        </div>
    </div>
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
    * {
        box-sizing: border-box;
    }

    /* Style inputs */
    input[type=text], select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        margin-top: 6px;
        margin-bottom: 16px;
        resize: vertical;
    }

    input[type=submit] {
        background-color: #04AA6D;
        color: white;
        padding: 12px 20px;
        border: none;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    /* Style the container/contact section */
    .container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 10px;
    }

    .header {
        margin-top: 50px;
    }

    /* Create two columns that float next to eachother */
    .column {
        float: left;
        width: 50%;
        margin-top: 6px;
        padding: 20px;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
        .column, input[type=submit] {
            width: 100%;
            margin-top: 0;
        }
    }

    .descbtn {
        background-color: #555555;
        color: white;
        padding: 5px 7px;
        border: none;
        cursor: pointer;
        width: 50%;
        opacity: 1;
    }

    .descbtn:hover {
        background-color: grey;
    }
</style>