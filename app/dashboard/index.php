<?php
require_once '../../config.php';
$isLogged = verificaUsuario(1);
if (isset($_SESSION['usuario']['cpf'])) atualizarSessionUsuario();
require_once '../../layout/start.php';

if (!isset($_GET['filtro'])) $_GET['filtro'] = "todos";
$filter = $_GET['filtro'];
?>

<div id="div-dashboard" class="container-fluid" style="margin: 0 auto; width: 90vw; height: 100vh">
     <?php
     include "./header.php";
     include "./filter.php";
     ?>

     <div class="adverts">
          <?php
          $cards = sanitize_array(getCards($filter));
          if (count($cards)) {
               foreach ($cards as $key => $card) {
                    $images = getFilesService($card['id']);
                    include "./card.php";
               }
          } else { ?>
               <div style="height: 60vh; display: flex; align-items: center;">
                    <h3 style="color: #ffffff">Não existem serviços cadastrados!</h3>
               </div>
          <?php } ?>
     </div>
     <nav aria-label="Page navigation example" style="margin-top: 1.5rem;">
          <ul class="pagination justify-content-end">
               <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
               </li>
               <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
               <li class="page-item"><a class="page-link" href="#">2</a></li>
               <li class="page-item"><a class="page-link" href="#">3</a></li>
               <li class="page-item">
                    <a class="page-link" href="#">Next</a>
               </li>
          </ul>
     </nav>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>dashboard.js"></script>
<script type="text/javascript">
     switchLoginDashboard('<?php echo isset($_SESSION['usuario']) ? "logged" : "logout"; ?>');

     document.getElementById('button_modal_servico').addEventListener('click', () => {

     })
</script>

<?php
require PATH_ASSETS_END;
?>