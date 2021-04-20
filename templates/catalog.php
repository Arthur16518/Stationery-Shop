<?php
    session_start();
?>

<div class="main-wrapper">
    <h1><?php echo $catName; ?></h1>
    <div class="products-section">
        <div class="filters">
            <div class="filter">
                <?php foreach ($categories as $category) {?>
                    <p><a href="index.php?action=catalog&id_category=<?php echo $category['id_category'];?>"><?php echo $category['name']?></a></p>
                <?php } ?>
            </div>
        </div>
        <div class="products">
            <div class="sort-block">
                <label for="sort-option">Сортировать по:</label>
                <div class="select-wrapper">
                    <select name="sort-option" id="sort-option" class="select" onchange="sortProducts(this.value, <?php echo $_GET['id_category']; ?>)">
                        <option value="cost-up">цене (по возрастанию)</option>
                        <option value="cost-down">цене (по убыванию)</option>
                        <option value="up" selected>названию (А - Я)</option>
                        <option value="down">названию (Я - А)</option>
                    </select>
                    <img src="<?php echo $this::TEMPLATES_PATH; ?>/img/arrow.svg" class="arrow-down" alt="arrow">
                </div>
            </div>
            <?php include_once $this::TEMPLATES_PATH.'products.php' ?>
        </div>
    </div>
</div>
<script src="<?php echo $this::TEMPLATES_PATH; ?>/js/catalog.js"></script>