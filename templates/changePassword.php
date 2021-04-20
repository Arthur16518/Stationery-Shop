<form action="" method="post" id="change-password" class="account-form disappear none" onsubmit="changePassword()">
    <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
    <div class="input-account">
        <label for="password1">Введите текущий пароль</label>
        <input required type="password" name="password1">
    </div>
    <div class="input-account">
        <label for="password2">Новый пароль</label>
        <input required type="password" name="password2" id="newPassword">
    </div>
    <div class="input-account">
        <label for="password3">Новый пароль еще раз</label>
        <input required type="password" name="password3" onchange="comparePasswords(document.getElementById('newPassword'), this)">
    </div>
    <button type="submit">ПОДТВЕРДИТЬ</button>
</form>