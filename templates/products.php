<?php
$str = 'В Корзину';
foreach ($products as $product) { ?>
<div class="product" onclick="getProduct(<?php echo $product['id_product'];?>)">
    <input type="number" hidden value="<?php echo $product['id_product'];?>" name="id_product">
    <img src="<?php echo $product['picture_path'] ?>" alt="product image">
    <h3><?php echo $product['name'] ?></h3>
    <p class="product-category"><?php echo $product['categoryName'] ?></p>
    <div class="cost-cart">
        <p class="cost"><?php echo $product['cost'] ?></p>
        <button class="add-to-cart" onclick="<?php
        if (isset($_SESSION['userId'])) echo 'addToCart(event, '.$product['id_product'].')'; else echo 'addToCart(event)'
        ?>" <?php if (isset($_SESSION['userId'])) if (in_array($product['id_product'], $_SESSION['cart'])) {echo 'disabled'; $str = 'В корзине';} else $str = 'В Корзину';?>>
            <img src="<?php echo $this::TEMPLATES_PATH; ?>/img/cart.svg" alt="add-to-cart">
            <?php echo $str; ?>
        </button>
    </div>
</div>
<?php } ?>