<div class="carousel-wrapper">
    <div class="carousel">
        <?php foreach ($pictures as $pic) {
            echo '<a href="'.$pic['link'].'"><img src="' . $pic['content_path'] . '" class="carousel-item"></a>';
        } ?>
    </div>
    <div class="controls">
        <img src="<?php echo $this::TEMPLATES_PATH;?>/img/arrow.svg" alt="arrow-left" class="clickable" onclick="switchCarousel(-1)">
        <div id="dots">
            <?php for ($i = 0; $i < count($pictures); $i++) {?>
                <div class="dot clickable" onclick="switchCarousel(<?php echo $i; ?>)" <?php if ($i == 0) echo 'id="active-dot"'?>></div>
            <?php } ?>
        </div>
        <img src="<?php echo $this::TEMPLATES_PATH;?>/img/arrow.svg" alt="arrow-left" class="clickable" onclick="switchCarousel()" style="transform: rotateZ(180deg);">
    </div>
</div>
<script src="<?php echo $this::TEMPLATES_PATH;?>/js/carousel.js"></script>