
<body>
<div class="button">
    <button class="tablink" onclick="window.location='/catalog';">Каталог</button>
    <button class="tablink" onclick="window.location='/cart';">Корзина<span class="badge"><?php echo $count ?? 0 ?></span></button>
<button class="tablink" onclick="window.location='/orders';">Заказы</button>
<button class="tablink" onclick="window.location='/logout';">Выйти из аккаунта</button>
</div>

<div id="main" class="main">
        <div class="main_item">
            <div class="card" >
                <img src="<?php echo $product->getImage()?>" alt="Carnaval Costumes">
                <div class="container">
                    <h1><?php echo $product->getName()?></h1>
                    <p class="price"><?php echo $product->getPrice()?> руб.</p>
                    <p><?php echo $product->getDescription()?></p>
                </div>
            </div>
        </div>
    <div class="review">
        <form action="action_page.php">
            <div class="rating-area" style="text-align: right">
                <p>Пожалуйста, оцените товар</p>
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

            <label for="positive">Преимущества</label>
            <input type="text" id="positive" name="positive" placeholder="Напишите основные преимущества">

            <label for="negative">Недостатки</label>
            <input type="text" id="negative" name="negative" placeholder="Напишите основные недостатки">

            <label for="comment">Комментарий</label>
            <textarea id="comment" name="comment" placeholder="Напишите комментарий" style="height:200px"></textarea>

            <input type="submit" value="Оставить отзыв">
        </form>
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
        margin-top: 0;
    }
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: auto;
        text-align: center;
        font-family: arial;
    }

    .card img {
        max-width:100%;
        height:auto;
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
</style>

<style>
    * {box-sizing: border-box}

    /* Bordered form */
    form {
        border: none;
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

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }
</style>

<style>
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

    /* Style inputs with type="text", select elements and textareas */
    input[type=text], select, textarea {
        width: 100%; /* Full width */
        padding: 12px; /* Some padding */
        border: 1px solid #ccc; /* Gray border */
        border-radius: 4px; /* Rounded borders */
        box-sizing: border-box; /* Make sure that padding and width stays in place */
        margin-top: 6px; /* Add a top margin */
        margin-bottom: 16px; /* Bottom margin */
        resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
    }

    /* Style the submit button with a specific background color etc */
    input[type=submit] {
        background-color: #04AA6D;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* When moving the mouse over the submit button, add a darker green color */
    input[type=submit]:hover {
        background-color: #45a049;
    }

    /* Add a background color and some padding around the form */
    .review {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
    }
</style>
