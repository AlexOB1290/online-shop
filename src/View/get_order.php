<form action="/order" method=POST>
    <div class="container">
        <h1>Order form</h1>
        <p>Please fill in this form to create an order.</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <label style="color: red;">
            <?php echo $errors['name']??"";?></label>
        <input type="text" placeholder="Enter Name" name="name" id="name" value="<?php echo $userData['name'] ?? ""; ?>" required>

        <label for="email"><b>Email</b></label>
        <label style="color: red;">
            <?php echo $errors['email']??"";?></label>
        <input type="email" placeholder="Enter Email" name="email" id="email" value="<?php echo $userData['email'] ?? ""; ?>" required>

        <label for="psw"><b>Address</b></label>
        <label style="color: red;">
            <?php echo $errors['address']??"";?></label>
        <input type="text" placeholder="Enter Address" name="address" id="address" required>

        <label for="telephone"><b>Telephone</b></label>
        <label style="color: red;">
            <?php echo $errors['telephone']??"";?></label>
        <input type="tel" placeholder="Enter Telephone number" name="telephone" id="telephone" required>
        <hr>

        <button type="submit" class="orderbtn">Place an order</button>
    </div>

    <div class="container cart">
        <p>Do you want to move <a href="/cart">Cart</a>?</p>
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
    }

    .orderbtn:hover {
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
</style>
