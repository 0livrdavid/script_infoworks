<!--FAVICON-->
<link rel="icon" type="image/x-icon" href="<?php echo URL_BASE_ASSETS_IMG; ?>InfoWorks_logo_fundo.ico">

<!--CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE_ASSETS_CSS; ?>theme_light.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE_ASSETS_CSS; ?>modify.css">
<?php
if ($_SERVER['PHP_SELF'] == "/app/dashboard/index.php") {
    echo "<link rel='stylesheet' type='text/css' href='".URL_BASE_ASSETS_CSS."dashboard.css' >";
} else if ($_SERVER['PHP_SELF'] == "/app/login_cadastro/index.php") {
    echo "<link rel='stylesheet' type='text/css' href='".URL_BASE_ASSETS_CSS."login_cadastro.css' >";
} else if ($_SERVER['PHP_SELF'] == "/app/perfil/index.php") {
    echo "<link rel='stylesheet' type='text/css' href='".URL_BASE_ASSETS_CSS."perfil.css' >";
} else if ($_SERVER['PHP_SELF'] == "/app/servicos/index.php") {
    echo "<link rel='stylesheet' type='text/css' href='".URL_BASE_ASSETS_CSS."servicos.css' >";
}
?>

