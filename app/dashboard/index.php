<?php
require_once '../../config.php';
require_once '../../layout/start.php';
require_once '../../ajax/dashboard/dashboard.php';

//session_destroy();
?>

<div id="div-dashboard" class="container-fluid" style="margin: 0 auto; width: 90vw; height: 100vh">
    <?php include "./header.php" ?>
    <?php include "./filter.php" ?>

    <div class="adverts">
        <?php
        $cards = sanitize_array(getCards($filter));
        foreach ($cards as $card){
            $dado['nome'] = resume_nome($card['nome']);
            $dado['idade'] = calcularIdade($card['idade']);
            $dado['categoria'] = $card['categoria'];
            $dado['valor'] = $card['valor'];
            $dado['tipoValor'] = $card['tipoValor'];
            include "./card.php";
        }
        //include "./cards.php"
        ?>
    </div>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>dashboard/dashboard.js"></script>
<script type="text/javascript" defer>
    switchLoginDashboard('<?php echo json_encode($_SESSION['usuario']) ?>');
</script>

<?php
require PATH_ASSETS_END;
?>
