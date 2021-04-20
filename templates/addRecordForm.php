<form action="" method="post" id="add-record-form" enctype="multipart/form-data" class="disappear none">
    <img src="<?php echo $this::TEMPLATES_PATH; ?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
    <h2>ДОБАВИТЬ ЗАПИСЬ</h2>
    <input type="text" hidden value="<?php echo $table; ?>" name="table">
    <?php foreach ($fields as $key=>$field) {
        if (($key == 'password' && $table != 'admins') || $field == 'ID')
            continue;
    ?>
        <label for="<?php echo $key; ?>"><?php echo $field; ?></label>
        <?php if (in_array($key, self::IMAGE_REQUIRED)) { ?>
            <input type="file" name="<?php echo $key; ?>" accept="image/jpeg,image/png" required>
        <?php } elseif (in_array($key, self::TEXTAREA_REQUIRED)) {?>
            <textarea name="<?php echo $key; ?>" cols="30" rows="3"></textarea>
        <?php } elseif (in_array($key, self::SELECT_REQUIRED[$table])) {?>
            <select name="<?php echo $key; ?>">
                <option value="NULL" selected>NULL</option>
                <?php foreach ($selects[$key] as $option) { $optionkeys = array_keys($option); ?>
                    <option value="<?php echo $option[$optionkeys[0]]; ?>"><?php echo $option[$optionkeys[1]]; ?></option>
                <?php } ?>
            </select>
        <?php } else { ?>
            <input type="<?php if ($key == 'email') echo 'email'; else echo 'text'?>" name="<?php echo $key; ?>" autocomplete="off" required <?php if ($table == 'admins') echo 'onchange="checkAdminLogin(this)"';?>>
        <?php } ?>
    <?php } ?>
    <button type="submit">ДОБАВИТЬ</button>
</form>