<?php
require_once '../../config.php';
require_once '../../layout/start.php';

$estados = getEstados();
$cidades = getCidades();

if (isset($_SESSION['usuario']['cpf'])) atualizarSessionUsuario();
?>

<div id="div-dashboard" class="container-fluid" style="margin: 0 auto; width: 90vw; height: 100vh">
  <?php include "./header.php" ?>

  <div class="form-user">
    <div class="container">
      <h1>Perfil</h1>
    </div>
    <div class="container">
      <?php include "./form_user.php" ?>
    </div>
    <div class="container">
      <div style="float: right;">
        <button class="btn btn-outline-danger" onclick="deslogarUsuario()">Deslogar</button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-adicionar-servico">Adicionar Serviço</button>
        <button class="btn btn-primary" onclick="salvarPerfil()">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>perfil.js"></script>
<script type="text/javascript">
  switchLoginDashboard('<?php echo isset($_SESSION['usuario']) ? "logged" : "logout"; ?>');
</script>

<?php
require PATH_ASSETS_END;
?>