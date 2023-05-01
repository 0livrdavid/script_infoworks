<?php
require_once '../../config.php';
require_once '../../layout/start.php';

$page = (string) $_POST['page'];
if (isset($_GET['page'])) $page = $_GET['page']; ?>

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

<script defer src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>login_cadastro.js"></script>
<script type="text/javascript" defer>
    window.onload = function() {
        switchLogin("<?php echo $page ?>");
    };
</script>

<?php
require PATH_ASSETS_END;
?>
