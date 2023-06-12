<?php
require_once '../../config.php';
$isUserMaster = verificaUsuario(1);
if (isset($_SESSION['usuario']['cpf'])) atualizarSessionUsuario();
require_once '../../layout/start.php';

$idServico = $_GET['id'];
$service = sanitize_array(getService($idServico))[0];
$user = sanitize_array(getUser("", $service['fk_idUsuario']));
?>

<div id="div-servicos" class="container-fluid" style="margin: 0 auto; width: 90vw; height: 100vh">
     <?php include "./header.php" ?>

     <div class="container">
          <div class="d-flex flex-row justify-content-between px-3">
               <h1>Serviço</h1>
               <?php echo ($_SESSION['idUsuario'] == $user['id']) ? "<button class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#modal-adicionar-servico\" onclick=\"getServico($idServico)\">EDITAR</button>" : "" ?>
          </div>
          <?php

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
<script defer src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>crop_image.js"></script>
<script type="text/javascript">
     switchLoginDashboard('<?php echo isset($_SESSION['usuario']) ? "logged" : "logout"; ?>');
</script>
<?php
require PATH_ASSETS_END;
?>