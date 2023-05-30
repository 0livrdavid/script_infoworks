<?php
require_once '../../config.php';
componentPhpFile();
if (isset($_SESSION['usuario']['cpf'])) atualizarSessionUsuario();
require_once '../../layout/start.php';

if (!isset($_GET['filtro'])) $_GET['filtro'] = "todos";
$filter = $_GET['filtro'];
?>

<div id="div-dashboard" class="container-fluid" style="margin: 0 auto; width: 90vw; height: 100vh">
    <?php 
        include "./header.php";
        include "./filter.php";
    ?>

    <div class="adverts">
        <?php
        $cards = sanitize_array(getCards($filter));
        if (count($cards)) {
            foreach ($cards as $key => $card) {
                $images = getFilesService($card['id']);
                include "./card.php";
            }
        } else { ?>
            <div style="height: 60vh; display: flex; align-items: center;">
                <h3 style="color: #ffffff">Não existem serviços cadastrados!</h3>
            </div>
        <?php } ?>
    </div>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>dashboard.js"></script>
<script type="text/javascript">
  switchLoginDashboard('<?php echo isset($_SESSION['usuario']) ? "logged" : "logout"; ?>');
</script>

<?php
require PATH_ASSETS_END;
?>