<!--FAVICON-->
<link rel="icon" type="image/x-icon" href="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo_fundo.ico">

<!--RESET CSS-->
<link rel="stylesheet" href="<?php echo URL_BASE_ASSETS_CSS; ?>reset.css">

<!--CSS-->
<link rel="stylesheet" href="<?php echo URL_BASE_ASSETS_CSS; ?>theme_light.css">
<?php
if ($_SERVER['PHP_SELF'] == "/app/dashboard/index.php") {
    echo "<link rel='stylesheet' href='".URL_BASE_ASSETS_CSS."dashboard.css' >";
} else if ($_SERVER['PHP_SELF'] == "/app/login_cadastro/index.php") {
    echo "<link rel='stylesheet' href='".URL_BASE_ASSETS_CSS."login_cadastro.css' >";
}
?>

