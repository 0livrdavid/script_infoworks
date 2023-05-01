<?php
require_once '../../config.php';
require_once '../../layout/start.php';

?>
<link rel="stylesheet" href="perfil.css">

<div id="div-dashboard" class="container-fluid" style="margin: 0 auto; width: 90vw; height: 100vh">
    <?php include "./header.php" ?>
    <div class="form-user">
        
    </div>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>dashboard/dashboard.js"></script>
<script type="text/javascript" defer>
    switchLoginDashboard('<?php echo json_encode($_SESSION['usuario']) ?>');
</script>

<?php
require PATH_ASSETS_END;
?>
