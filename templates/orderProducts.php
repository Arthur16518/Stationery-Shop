<?php
    const RUS_NAMES = [
        'id_order' => 'Номер заказа',
        'sum' => 'Сумма',
        'name' => 'Имя',
        'address' => 'Адрес',
        'phone' => 'Номер телефона'
    ];
    const PRODUCT_FIELDS = [
        'id_product' => 'ID',
        'picture_path' => 'Картинка',
        'name' => 'Название',
        'count' => 'Количество',
        'cost' => 'Стоимость за шт.'
    ];
?>

<div id="order-products" class="order-data disappear none">
    <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
    <h2>Информация о заказе</h2>
    <table>
        <?php foreach ($mainData as $key=>$row) {?>
            <tr>
                <td colspan="3"><?php echo RUS_NAMES[$key]; ?></td>
                <td colspan="2"><?php echo $row; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="5"><h3>Товары в заказе</h3></td>
        </tr>
        <tr>
        <?php foreach (PRODUCT_FIELDS as $FIELD) {?>
            <td><?php echo $FIELD; ?></td>
        <?php } ?>
        </tr>
        <?php foreach ($products as $product) {?>
            <tr>
                <?php foreach ($product as $key=>$field) {?>
                    <td>
                    <?php if ($key != 'picture_path')
                        echo $field;
                    else
                        echo '<img src="'.$field.'">'
                    ?>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
</div>