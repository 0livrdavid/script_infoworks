<!--FAVICON-->
<link rel="icon" type="image/x-icon" href="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo_fundo.ico">

<!--BOOSTRAP CSS-->
<link rel="stylesheet" href="<?php echo URL_BASE_ASSETS_CSS; ?>reset.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<!--CSS-->
<link rel="stylesheet" href="<?php echo URL_BASE_ASSETS_CSS; ?>theme_light.scss">
<?php
if ($_SERVER['PHP_SELF'] == "/app/dashboard/index.php") {
    echo "<link rel='stylesheet' href='".URL_BASE_ASSETS_CSS."dashboard.scss'";
} else if ($_SERVER['PHP_SELF'] == "/app/login_cadastro/index.php") {
    echo "<link rel='stylesheet' href='".URL_BASE_ASSETS_CSS."login_cadastro.scss'";
}
?>

