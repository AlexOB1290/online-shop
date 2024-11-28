<div id="main" class="main">
    <?php foreach ($productsData as $product) : ?>
        <div class="main_item">
            <div class="card" >
                <img src="<?php echo $product['image']?>" alt="Carnaval Costumes" style="max-width:100%; height:auto">
                <div class="container">
                    <h1><?php echo $product['name']?></h1>
                    <p class="price"><?php echo $product['price']?> руб.</p>
                    <p><?php echo $product['description']?></p>
                    <p><button>Добавить в корзину</button></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="container add">
    <p> Do you want to <a href="/add-product"> Add product</a>?</p>
</div>
<div class="container logout">
    <p>Do you want to log out of your account? <a href="/logout">Exit</a>.</p>
</div>





<style>
    .img{
        background-image: url("https://wallpapers.99px.ru/cms/mhost.php?tid=53&act=getimage&id=362662");
        background-size: auto;
        background-position: center;
        height: auto;
        width: auto;
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