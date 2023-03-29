<?php
var_dump($_POST);

require_once '../../config.php';
require_once '../../layout/start.php';

require_once '../../ajax/login_cadastro/login.php';
require_once '../../ajax/login_cadastro/cadastro.php';
require_once '../../ajax/login_cadastro/esqueceu_senha.php';
?>

<div class="div-login-cadastrar">
    <div id="div-login">
        <?php include "./login.php" ?>
    </div>
    <div id="div-cadastro">
        <?php include "./cadastro.php" ?>
    </div>
    <div id="div-esqueceu-senha">
        <?php include "./esqueceu_senha.php" ?>
    </div>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>login_cadastro/login_cadastro.js"></script>
<script type="text/javascript" defer>
    window.onload = function() {
        switchLogin("<?php echo $page ?>");
    };
</script>

<?php
require PATH_ASSETS_END;
?>
