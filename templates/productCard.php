<?php $str = 'В Корзину' ?>
<div id="product-card" class="account-form disappear none">
    <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
    <table>
        <tr>
            <td rowspan="4" class="card-image">
                <img src="<?php echo $product['picture_path']; ?>" alt="product image">
            </td>
            <td colspan="2">
                <h3><?php echo $product['name']; ?></h3>
            </td>
            <td class="product-manufacturer">
                <span onclick="getManufacturer(<?php echo $product['id_manufacturer']; ?>)"><?php echo $product['manufacturerName']; ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="product-category">
                <?php echo $product['categoryName']; ?>
            </td>
        </tr>
        <tr>
            <td class="cost">
                <?php echo $product['cost']; ?>
            </td>
            <td colspan="2">
                <button class="add-to-cart" onclick="<?php
                if (isset($_SESSION['userId'])) echo 'addToCart('.$product['id_product'].')'; else echo 'addToCart()'
                ?>" <?php if (isset($_SESSION['userId'])) if (in_array($product['id_product'], $_SESSION['cart'])) {echo 'disabled'; $str = 'В корзине';}?>>
                    <img src="<?php echo $this::TEMPLATES_PATH; ?>/img/cart.svg" alt="add-to-cart">
                    <?php echo $str; ?>
                </button>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php echo $product['description']; ?>
            </td>
        </tr>
    </table>
</div>