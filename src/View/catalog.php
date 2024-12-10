<div id="main" class="main">
    <?php foreach ($productsData as $product) : ?>
        <div class="main_item">
            <div class="card" >
                <img src="<?php echo $product['image']?>" alt="Carnaval Costumes" style="max-width:100%; height:auto">
                <div class="container">
                    <h1><?php echo $product['name']?></h1>
                    <p class="price"><?php echo $product['price']?> руб.</p>
                    <p><?php echo $product['description']?></p>
                    <form action="/add-product" method=POST>
                        <div class="container">
                            <label style="color: red;">
                                <?php echo $errors['product-id']??"";?></label>
                            <input type="hidden" name="product-id" id="product-id" value="<?php echo $product['id']; ?>" required>

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
<div class="container logout">
    <p>Do you want to move <a href="/cart">Cart</a>?</p>
</div>
<div class="container logout">
    <p>Do you want to move <a href="/orders">Orders</a>?</p>
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

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

</style>