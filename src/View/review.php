
<body>
<div class="button">
    <button class="tablink" onclick="window.location='/catalog';">Каталог</button>
    <button class="tablink" onclick="window.location='/cart';">Корзина<span class="badge"><?php echo $count ?? 0 ?></span></button>
    <button class="tablink" onclick="window.location='/orders';">Заказы</button>
    <button class="tablink" onclick="window.location='/logout';">Выйти из аккаунта</button>
</div>
<div class="container">
    <div class="header" style="text-align:center">
        <h2>Пожалуйста, оставьте отзыв о товаре</h2>
    </div>
    <div class="row">
        <div class="column">
            <img src="<?php echo $product->getImage()?>" style="width:30%">
            <h1><?php echo $product->getName()?></h1>
            <p class="price">Стоимость <?php echo $product->getPrice()?> руб.</p>
            <p><?php echo $product->getDescription()?></p>
        </div>
        <div class="column">
            <form action="/add-review" method="POST">
                <input type="hidden" name="product-id" id="product-id" value="<?php echo $product->getId(); ?>" required>

                <p>Оцените товар по шкале от 1 до 5 звезд</p>
                <label style="color: red;">
                    <?php echo $errors['rating']??"";?></label>
                <div class="rating-area">
                    <input type="radio" id="star-5" name="rating" value="5">
                    <label for="star-5" title="Оценка «5»"></label>
                    <input type="radio" id="star-4" name="rating" value="4">
                    <label for="star-4" title="Оценка «4»"></label>
                    <input type="radio" id="star-3" name="rating" value="3">
                    <label for="star-3" title="Оценка «3»"></label>
                    <input type="radio" id="star-2" name="rating" value="2">
                    <label for="star-2" title="Оценка «2»"></label>
                    <input type="radio" id="star-1" name="rating" value="1">
                    <label for="star-1" title="Оценка «1»"></label>
                </div>

                <label for="positive">Достоинства</label>
                <label style="color: red;">
                    <?php echo $errors['positive']??"";?></label>
                <input type="text" id="positive" name="positive" placeholder="Напишите основные преимущества">

                <label for="negative">Недостатки</label>
                <label style="color: red;">
                    <?php echo $errors['negative']??"";?></label>
                <input type="text" id="negative" name="negative" placeholder="Напишите основные недостатки">

                <label for="comment">Комментарий</label>
                <label style="color: red;">
                    <?php echo $errors['comment']??"";?></label>
                <textarea id="comment" name="comment" placeholder="Напишите комментарий" style="height:200px"></textarea>

                <input type="submit" value="Оставить отзыв">
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

    .rating-area {
        overflow: hidden;
        width: 265px;
        margin: 0 auto;
    }
    .rating-area:not(:checked) > input {
        display: none;
    }
    .rating-area:not(:checked) > label {
        float: right;
        width: 42px;
        padding: 0;
        cursor: pointer;
        font-size: 32px;
        line-height: 32px;
        color: lightgrey;
        text-shadow: 1px 1px #bbb;
    }
    .rating-area:not(:checked) > label:before {
        content: '★';
    }
    .rating-area > input:checked ~ label {
        color: gold;
        text-shadow: 1px 1px #c60;
    }
    .rating-area:not(:checked) > label:hover,
    .rating-area:not(:checked) > label:hover ~ label {
        color: gold;
    }
    .rating-area > input:checked + label:hover,
    .rating-area > input:checked + label:hover ~ label,
    .rating-area > input:checked ~ label:hover,
    .rating-area > input:checked ~ label:hover ~ label,
    .rating-area > label:hover ~ input:checked ~ label {
        color: gold;
        text-shadow: 1px 1px goldenrod;
    }
    .rate-area > label:active {
        position: relative;
    }
</style>
