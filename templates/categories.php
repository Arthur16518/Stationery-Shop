<div class="main-wrapper">
    <h1>КАТАЛОГ</h1>
    <div class="categories-grid">
        <?php foreach ($bigCategories as $bigCategory) {
            echo '<h2><a href="index.php?action=catalog&id_category='.$bigCategory['id_category'].'">'.$bigCategory['name'].'</a></h2>';
            foreach ($smallCategories as $smallCategory) {
                if ($smallCategory['id_category_parent'] == $bigCategory['id_category']) {
                    echo '<p><a href="index.php?action=catalog&id_category='.$smallCategory['id_category'].'">'.$smallCategory['name'].'</a></p>';
                }
            }
        } ?>
    </div>
</div>
