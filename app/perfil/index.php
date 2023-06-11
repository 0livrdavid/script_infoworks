<?php
require_once '../../config.php';
verificaUsuario();
if (isset($_SESSION['usuario']['cpf'])) atualizarSessionUsuario();
require_once '../../layout/start.php';

$estados = getEstados();
$cidades = getCidades();
?>

<div id="div-perfil" class="container-fluid" style="margin: 0 auto; width: 90vw; height: 100vh">
     <?php include "./header.php" ?>

     <div class="form-user">
          <div class="container">
               <h1>Perfil</h1>
               <?php include "./form_user.php" ?>
          </div>
          <div class="container">
               <div style="float: right;">
                    <button class="btn btn-outline-danger" onclick="deslogarUsuario()">Deslogar</button>
                    <button id="button_modal_servico" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-adicionar-servico">Adicionar Serviço</button>
                    <button class="btn btn-primary" onclick="salvarPerfil()">Salvar</button>
               </div>
          </div>
          <div class="container">
               <h1>Meus Serviços</h1>
               <?php
               $services = sanitize_array(getServices());
               if (count($services)) {
                    foreach ($services as $key => $service) {
                         include "./servicos.php";
                    }
               } else { ?>
                    <h3>Não existem serviços cadastrados!</h3>
               <?php } ?>
          </div>
     </div>
</div>

<script defer src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>perfil.js"></script>
<script defer src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>servicos.js"></script>
<script defer src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>crop_image.js"></script>
<script type="text/javascript">
     switchLoginDashboard('<?php echo isset($_SESSION['usuario']) ? "logged" : "logout"; ?>');

     var fk_estado = '<?php echo $_SESSION['usuario']['fk_estado'] ?>';
     var fk_cidade = <?php echo $_SESSION['usuario']['fk_cidade'] ?>;
     
     document.getElementById('button_modal_servico').addEventListener('click', () => {
          $('#servico_categoria').val('');
          $('#servico_preco').val('');
          $('#servico_tipo').val('');
          $('#servico_descricao').summernote('code', '');
          document.getElementById('service_accordion_image').innerHTML = '';
     })
</script>

<?php
require PATH_ASSETS_END;
?>