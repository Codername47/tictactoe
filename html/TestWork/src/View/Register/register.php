<?php
?>
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
<form action="../auth/reg" method="post">
    <h2>Регистрация</h2>
    <ul>
        <li>
            <label for="login">login</label>
            <input name="login" type="text">
        </li>
        <li>
            <label for="password">password</label>
            <input name="password" type="text">
        </li>
        <li>
            <label for="password">repeatPassword</label>
            <input name="repeatPassword" type="text">
        </li>
        <li>
            <button type="submit">Отправить</button>
        </li>
    </ul>
    <?php if(isset($_SESSION['err'])):?>
        <b><?=$_SESSION['err']; ?></b>
    <?php endif;?>
    <?php
        unset($_SESSION['err']);
    ?>
</form>
</body>
</html>
