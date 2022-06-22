<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="../auth/authorizate" method="post">
    <h2>Авторизация</h2>
    <ul>
        <li>
            <label for="login">login</label>
            <input type="text" name="login">
        </li>
        <li>
            <label for="password">password</label>
            <input type="text" name="password">
        </li>
        <li>
            <button type="submit">Войти</button>
        </li>
        <?php if(isset($_SESSION['err'])):?>
            <b><?=$_SESSION['err']; ?></b>
        <?php endif;?>
        <?php
        unset($_SESSION['err']);
        ?>
    </ul>
</form>
</body>
</html>
