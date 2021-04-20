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
    <link rel="stylesheet" href="<?php echo $this::TEMPLATES_PATH;?>/css/cms.css">
    <link rel="shortcut icon" href="<?php echo $this::TEMPLATES_PATH;?>/img/cms-icon.ico" type="image/x-icon">
</head>
<body>
    <aside id="menu">
        <div class="aside-wrapper">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/admin-icon.svg" alt="CMS">
            <div class="sections">
                <p class="clickable">ЛЕНТА</p>
                <p class="clickable">ЗАКАЗЫ</p>
                <p class="clickable">ТОВАРЫ</p>
                <p class="clickable">КАТЕГОРИИ</p>
                <p class="clickable">ПОЛЬЗОВАТЕЛИ</p>
                <p class="clickable">ПРОИЗВОДИТЕЛИ</p>
                <p class="clickable">АДМИНИСТРАТОРЫ</p>
            </div>
            <div class="aside-bottom clickable">
                <a href="index.php?action=sessionDestroy">ВЫЙТИ</a>
            </div>
        </div>
    </aside>
    <section class="main-section">
    </section>
    <div class="overlay">
        <form action="" method="post" id="picture-form" enctype="multipart/form-data" class="disappear none">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
            <h2>СМЕНА ИЗОБРАЖЕНИЯ</h2>
            <div class="pics">
                <div id="previous-picture">
                    <img src="" alt="previous-picture">
                </div>
                <img src="<?php echo $this::TEMPLATES_PATH;?>/img/arrow.svg" alt="" class="arrow-down" style="transform: rotateZ(180deg)">
                <div id="new-picture">
                    <img src="" alt="new-picture" class="none">
                    <input type="file" name="newPicture" accept="image/jpeg,image/png" required>
                </div>
            </div>
            <button type="submit" id="change-picture">ПОДТВЕРДИТЬ</button>
        </form>
    </div>
    <script src="<?php echo $this::TEMPLATES_PATH;?>/js/cms.js"></script>
    <script src="<?php echo $this::TEMPLATES_PATH;?>/js/tabletools.js"></script>
</body>
</html>