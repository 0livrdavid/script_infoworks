<?php
require_once '../../config.php';
require_once '../../layout/start.php';
?>

<div id="div-servicos" class="container-fluid" style="margin: 0 auto; width: 90vw; height: 100vh">
  <?php include "./header.php" ?>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>servicos.js"></script>
<script type="text/javascript">
  switchLoginDashboard('<?php echo isset($_SESSION['usuario']) ? "logged" : "logout"; ?>');
</script>
<?php
require PATH_ASSETS_END;
?>