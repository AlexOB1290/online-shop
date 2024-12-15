<form action="/login" method="post">

    <div class="container">
        <h1>Авторизация</h1>
        <p>Пожалуйста, заполните поля ниже для входа в аккаунт.</p>
        <hr>

        <label for="email"><b>Email</b></label>
        <label style="color: red;">
            <?php echo $errors['email']??"";?></label>
        <input type="text" placeholder="Введите email" name="email" required>

        <label for="psw"><b>Пароль</b></label>
        <label style="color: red;">
            <?php echo $errors['password']??"";?></label>
        <input type="password" placeholder="Введите пароль" name="psw" required>

        <button type="submit">Войти</button>
        <label>
            <input type="checkbox" checked="checked" name="remember"> Запомнить меня (пока не работает)
        </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" class="cancelbtn" onclick="window.location = '/registrate'">Отмена</button>
        <span class="psw">Начать <a href="/registrate">регистрацию</a></span>
    </div>
</form>

<style>
    /* Bordered form */
    form {
        border: 3px solid #f1f1f1;
    }

    /* Full-width inputs */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for all buttons */
    button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    /* Add a hover effect for buttons */
    button:hover {
        opacity: 0.8;
    }

    /* Extra style for the cancel button (red) */
    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* The "Forgot password" text */
    span.psw {
        float: right;
        padding-top: 16px;
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }
        .cancelbtn {
            width: 100%;
        }
    }
</style>