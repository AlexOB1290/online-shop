<div id="main" class="main">
    <h1> <?php echo "Ваш заказ № {$userOrder['id']} оформлен <br>";
    echo "Общая сумма заказа: {$userOrder['total']} руб. <br>";
    echo "Имя заказчика: {$userOrder['name']} <br>";
    echo "Адрес заказа: {$userOrder['address']} <br>";
    echo "Номер телефона: {$userOrder['telephone']} <br>"?> </h1>
</div>
<div class="button">
    <p><button onclick="window.location='/catalog';">To catalog</button></p>
</div>

<div class="container add">
    <p> Do you want to <a href="/add-product"> Add product</a>?</p>
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

    .button {
        border: none;
        outline: 0;
        padding: 12px;
        color: white;
        background-color: #04AA6D;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
        margin: auto;
    }

    .button:hover {
        opacity: 0.7;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .logout {
        background-color: #f1f1f1;
        text-align: center;
    }

    .add {
        background-color: #04AA6D;
        text-align: center;
    }
</style>
