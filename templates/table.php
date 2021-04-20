<h1 id="tableName"><?php echo $tableName; ?></h1>
<table id="<?php echo CMSController::DATA_ASSOC[$tableName]?>">
    <thead>
        <td class="tools"></td>
        <td class="tools"></td>
        <?php foreach ($keys as $key) {?>
            <td id="<?php echo $key; ?>"><?php echo $rucolumns[$key]; ?></td>
        <?php } ?>
    </thead>
    <tbody>
        <?php foreach ($data as $row) {?>
            <tr>
                <td class="tools">
                    <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="delete" class="clickable" title="Удалить" onclick="deleteRecord(this.parentElement)">
                </td>
                <td class="tools">
                    <img src="<?php echo $this::TEMPLATES_PATH;?>/img/edit.svg" alt="edit" class="clickable" title="Редактировать" onclick="switchEditButton(this)">
                </td>
                <?php foreach ($row as $key=>$cell) { ?>
                    <td class="<?php echo $rucolumns[$key].' '.$key; ?>">
                        <?php if (in_array($key, self::IMAGE_REQUIRED)) { ?>
                            <img src="<?php echo $cell; ?>" class="image-data" ondblclick="showPictureForm(this, '<?php echo $key; ?>')">
                        <?php } elseif (in_array($key, self::TEXTAREA_REQUIRED)) {?>
                            <textarea name="description" cols="30" rows="3" readonly><?php echo $cell; ?></textarea>
                        <?php } elseif (in_array($key, self::SELECT_REQUIRED[CMSController::DATA_ASSOC[$tableName]])) {?>
                            <select name="<?php echo $key; ?>" disabled>
                                <option value="NULL">NULL</option>
                                <?php foreach ($selects[$key] as $option) { $optionkeys = array_keys($option); ?>
                                    <option <?php if ($option[$optionkeys[0]] == $cell) echo 'selected'; ?> value="<?php echo $option[$optionkeys[0]]; ?>"><?php echo $option[$optionkeys[1]]; ?></option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <input type="<?php if ($key == 'password') echo 'password'; else echo 'text'; ?>" value="<?php echo $cell; ?>" name="<?php echo $key; ?>" readonly>
                        <?php } ?>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php if (in_array(CMSController::DATA_ASSOC[$tableName], self::ADD_REQUIRED)) {?>
<button onclick="getAddRecordForm('<?php echo CMSController::DATA_ASSOC[$tableName] ?>')" style="margin-bottom: 5vh;">ДОБАВИТЬ ЗАПИСЬ</button>
<?php } ?>