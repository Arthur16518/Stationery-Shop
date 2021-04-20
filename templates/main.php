<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="<?php echo $this::TEMPLATES_PATH;?>/css/style.css">
    <link rel="shortcut icon" href="<?php echo $this::TEMPLATES_PATH;?>/img/favicon.ico" type="image/x-icon">
</head>
<body>
    <header class="light-grey-bg">
        <a href="<?php echo 'index.php'?>"><img src="<?php echo $this::TEMPLATES_PATH;?>/img/logo.svg" alt="logo" class="clickable"></a>
        <form action="index.php" method="get" name="search">
            <input type="text" name="action" value="search" hidden>
            <input type="text" name="query" id="query" autocomplete="off" placeholder="Поиск товаров">
            <button type="submit"></button>
        </form>
        <a href="index.php?action=categories"><h2 class="clickable nav-item">КАТАЛОГ</h2></a>
        <h2 class="clickable nav-item <?php if(isset($_SESSION['userId'])) echo 'none'?>" onclick="showForm('sign-in')" id="sign-in-link">ВОЙТИ</h2>
        <h2 class="clickable nav-item <?php if(!isset($_SESSION['userId'])) echo 'none'?>" id="to-account" onclick="getAccount()">ЛИЧНЫЙ КАБИНЕТ</h2>
        <div class="shopping-cart clickable" onclick="cart()">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cart.svg" alt="cart" class="img-header">
            <?php if (isset($_SESSION['userId'])) {?>
                <div id="cart-count"><?php echo count($_SESSION['cart']); ?></div>
            <?php } ?>
        </div>
    </header>

    <main>
        <?php include_once $template.'.php' ?>
    </main>
    <footer class="light-grey-bg">
        <p class="dark-grey-text" onclick="showForm('admin-sign-in')">Войти в администраторскую учетную запись</p>
        <div class="contacts">
            <a href="https://t.me/str165" target="blank"><img src="<?php echo $this::TEMPLATES_PATH;?>/img/telegram.svg" alt="telegram"></a>
            <a href="https://github.com/Arthur16518" target="blank"><img src="<?php echo $this::TEMPLATES_PATH;?>/img/github.svg" alt="github"></a>
            <a href="mailto:artur.ik16518@gmail.com" target="blank"><img src="<?php echo $this::TEMPLATES_PATH;?>/img/email.svg" alt="email"></a>
        </div>
    </footer>
    <div class="overlay">
        <form action="" method="post" id="sign-in" class="account-form disappear none">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/logo.svg" alt="logo" class="img-form">
            <div class="input-account">
                <label for="login">Логин или Email</label>
                <input required type="text" name="login" id="login">
            </div>
            <div class="input-account">
                <label for="password">Пароль</label>
                <input required type="password" name="password" id="password">
                <p class="italic" id="forgot-password-text" onclick="{whoReset = 'user'; showForm('password-reset')}">Забыли пароль?</p>
            </div>            
            <button type="submit">ВОЙТИ</button>
            <p id="to-sign-up-text" onclick="showForm('sign-up')">Нет учетной записи? Регистрация</p>
        </form>
        <form action="" method="post" id="sign-up" class="account-form disappear none">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/logo.svg" alt="logo" class="img-form">
            <div class="input-account">
                <label for="login">Логин</label>
                <input required type="text" name="login" id="login">
            </div>
            <div class="input-account">
                <label for="password">Пароль</label>
                <input required type="password" pattern="^[\w+\d+]{6,20}$" name="password" id="password">
            </div>
            <div class="input-account">
                <label for="password2">Пароль еще раз</label>
                <input required type="password" name="password2" id="password2">
            </div>  
            <div class="input-account">
                <label for="email">Email</label>
                <input required type="email" name="email" id="email">
            </div>   
            <div class="input-account">
                <label for="phone">Номер телефона</label>
                <input required type="tel" name="phone" id="phone">
            </div>     
            <button type="submit">ЗАРЕГИСТРИРОВАТЬСЯ</button>
        </form>
        <form action="" method="post" id="admin-sign-in" class="account-form disappear none">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/admin-icon.svg" alt="admin-page" class="img-form">
            <div class="input-account">
                <label for="login">Логин или Email</label>
                <input required type="text" name="login" id="login">
            </div>
            <div class="input-account">
                <label for="password">Пароль</label>
                <input required type="password" name="password" id="password">
                <p class="italic" id="forgot-password-text" onclick="{whoReset = 'admin'; showForm('password-reset')}">Забыли пароль?</p>
            </div>            
            <button type="submit">ВОЙТИ</button>
        </form>
        <form action="" method="post" id="password-reset" class="account-form disappear none">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
            <h3 class="form-label">ВОССТАНОВЛЕНИЕ ПАРОЛЯ</h3>
            <div class="input-account">
                <label for="email">Введите ваш Email</label>
                <input required type="email" name="email">
            </div>
            <button type="submit">ВОССТАНОВИТЬ</button>
        </form>
        <div id="alert" class="account-form disappear none">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/exclamation.svg" alt="exclamation" class="img-form">
            <h2 class="message"></h2>
        </div>
        <div id="done" class="account-form disappear none">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/done-mark.svg" alt="done" class="img-form">
            <h2 class="message"></h2>
        </div>
    </div>
    <script src="<?php echo $this::TEMPLATES_PATH;?>/js/forms.js"></script>
    <script src="<?php echo $this::TEMPLATES_PATH;?>/js/main.js"></script>
</body>
</html>