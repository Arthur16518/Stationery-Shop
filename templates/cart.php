<div class="main-wrapper">
    <h1>КОРЗИНА</h1>
    <div class="products-with-form">
        <div class="product-list">
            <?php if (count($_SESSION['cart']) > 0) foreach ($products as $product) { ?>
                <div class="cart-item" id="<?php echo $product['id_product']; ?>">
                    <input type="checkbox" onchange="checkItem(this)">
                    <img src="<?php echo $product['picture_path']; ?>" alt="item picture">
                    <div class="item-center">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="cost"><?php echo $product['cost']; ?></p>
                        <div>
                            Количество: <input type="number" name="count" min="1" max="<?php echo $product['count'];?>" step="1" value="1" autocomplete="off" onchange="updateTotal(this)">
                        </div>
                    </div>
                    <p class="cost total-item-cost"><?php echo $product['cost']; ?></p>
                    <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="remove" class="cross clickable" onclick="deleteCartItem(this.parentElement)">
                </div>
            <?php } ?>
        </div>
        <form action="" id="make-order">
            <h2>Оформление заказа</h2>
            <label for="name">Имя</label>
            <input type="text" name="name" required autocomplete="off">
            <label for="phone">Номер телефона</label>
            <input type="tel" name="phone" value="<?php echo $user['phone']; ?>" autocomplete="off">
            <label for="address">Адрес доставки</label>
            <input type="text" name="address" autocomplete="off" value="<?php echo $user['address']; ?>">
            <h2 class="cost">0</h2>
            <button type="submit">ОФОРМИТЬ ЗАКАЗ</button>
        </form>
    </div>
</div>
<script src="<?php echo $this::TEMPLATES_PATH.'js/cart.js'?>"></script>