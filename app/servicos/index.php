<?php
require_once '../../config.php';
componentPhpFile();
verificaUsuario();
if (isset($_SESSION['usuario']['cpf'])) atualizarSessionUsuario();
require_once '../../layout/start.php';

$idServico = $_GET['id'];
?>

<div id="div-servicos" class="container-fluid" style="margin: 0 auto; width: 90vw; height: 100vh">
    <?php include "./header.php" ?>

    <div class="container">
        <h1>Serviço</h1>
        <?php
        $service = sanitize_array(getService($idServico))[0];
        if (count($service)) {
            include "./servico.php";
        } else { ?>
            <div class="adverts" style="height: 60vh; display: flex; align-items: center;">
                <h3 style="color: #ffffff">Serviço não encontrado!</h3>
            </div>
        <?php } ?>
    </div>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>servicos.js"></script>
<script type="text/javascript">
    switchLoginDashboard('<?php echo isset($_SESSION['usuario']) ? "logged" : "logout"; ?>');
</script>
<?php
require PATH_ASSETS_END;
?>