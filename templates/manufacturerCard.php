<div id="manufacturer-card" class="account-form disappear none">
    <img src="<?php echo $this::TEMPLATES_PATH;?>/img/cross.svg" alt="close" class="cross clickable" onclick="closeActiveForm()">
    <table>
        <tr>
            <td rowspan="2" class="card-image">
                <img src="<?php echo $manufacturer['logo_path']; ?>" alt="logo">
            </td>
            <td>
                <h3><?php echo $manufacturer['name']; ?></h3>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $manufacturer['description']; ?>
            </td>
        </tr>
    </table>
</div>