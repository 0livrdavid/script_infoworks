<?php
require_once '../../config.php';
//require_once '../../funcoes/FC_FuncoesBD.php';
//require_once '../../funcoes/FC_Sistema.php';
require_once '../../layout/start.php';
?>

<div class="div-login-cadastrar">
    <div id="div-login">
        <?php include "./login.php" ?>
    </div>
    <div id="div-cadastro">
        <?php include "./cadastro.php" ?>
    </div>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>login_cadastro/login_cadastro.js"></script>

<?php
require PATH_ASSETS_END;
?>
