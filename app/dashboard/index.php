<?php
require_once '../../config.php';
require_once '../../layout/start.php';
?>

<div id="div-dashboard" class="container-fluid" style="padding: 0 5%;">
    <?php include "./header.php" ?>
    <?php include "./filter.php" ?>

    <div class="adverts">
        <?php
        include "./card.php"
        //include "./cards.php"
        ?>
    </div>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>dashboard/dashboard.js"></script>

<?php
require PATH_ASSETS_END;
?>
