<?php
session_start();
?>

<div class="main-wrapper">
    <h1>Поиск товаров по запросу "<?php echo $searchQuery; ?>"</h1>
    <div class="products-section">
        <div class="products" style="width: 100%; grid-template-columns: 1fr 1fr 1fr 1fr; grid-template-rows: auto;">
            <?php include_once $this::TEMPLATES_PATH.'products.php' ?>
        </div>
    </div>
</div>
<script src="<?php echo $this::TEMPLATES_PATH; ?>/js/catalog.js"></script>