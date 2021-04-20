<form action="" method="post" id="account" class="account-form disappear none">
    <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
    <img src="<?php echo $this::TEMPLATES_PATH;?>/img/user.svg" alt="user" class="img-form">
    <div class="input-account">
        <label>Логин</label>
        <span>
            <input required type="text" name="login" value="<?php echo $login; ?>" placeholder="<?php echo $login; ?>" readonly onchange="checkUniqueness(this)">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/edit.svg" alt="edit" class="clickable" onclick="editUserData(this.parentElement)">
        </span>
    </div>
    <div class="input-account">
        <label for="email">Email</label>
        <span>
            <input required type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $email; ?>" readonly onchange="checkUniqueness(this)">
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/edit.svg" alt="edit" class="clickable" onclick="editUserData(this.parentElement)">
        </span>
    </div>
    <div class="input-account">
        <label for="address">Адрес доставки</label>
        <span>
            <input required type="text" name="address" value="<?php echo $address; ?>" placeholder="<?php echo $address; ?>" readonly>
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/edit.svg" alt="edit" class="clickable" onclick="editUserData(this.parentElement)">
        </span>
    </div>
    <div class="input-account">
        <label for="phone">Номер телефона</label>
        <span>
            <input required type="tel" name="phone" value="<?php echo $phone; ?>" placeholder="<?php echo $phone; ?>" readonly>
            <img src="<?php echo $this::TEMPLATES_PATH;?>/img/edit.svg" alt="edit" class="clickable" onclick="editUserData(this.parentElement)">
        </span>
    </div>
    <span>
        <button type="button" onclick="getChangePassword()">СМЕНИТЬ ПАРОЛЬ</button>
        <button type="button" onclick="signOut()">ВЫЙТИ</button>
    </span>
</form>