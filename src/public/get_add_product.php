<?php
if (session_status() == PHP_SESSION_ACTIVE) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
    }
} else {
    session_start();
}

?>


<form action="/add-product" method=POST>
    <div class="container">
        <h1>Add-product</h1>
        <p>Please fill in this form to add user product.</p>
        <hr>

        <label for="product-id"><b>Product-id</b></label>
        <label style="color: red;">
            <?php echo $errors['product-id']??"";?></label>
        <input type="text" placeholder="Enter Product-id" name="product-id" id="product-id" required>

        <label for="amount"><b>Amount</b></label>
        <label style="color: red;">
            <?php echo $errors['amount']??"";?></label>
        <input type="text" placeholder="Enter Amount" name="amount" id="amount" required>

        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Add to cart</button>
    </div>
    <div class="container cart">
        <p>Do you want to <a href="/cart">Cart</a>?</p>
    </div>
    <div class="container logout">
        <p>Do you want to log out of your account? <a href="/logout">Exit</a>.</p>
    </div>
</form>


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

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
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

    /* Set a grey background color and center the text of the "sign in" section */
    .cart {
        background-color: #f1f1f1;
        text-align: center;
    }

    .logout {
        background-color: #f1f1f1;
        text-align: center;
    }

</style>