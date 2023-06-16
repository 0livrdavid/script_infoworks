<h4 class="tema mb-3">Avaliação</h4>
<div class="row mb-3">
     <div class="col">
          <div class="row d-flex flex-row align-items-baseline">
               <span class="col-2"><i class="bi bi-star-fill rating-color me-3"></i>5 Estrelas</span>
               <div class="col progress" style="padding: 0px !important;">
                    <?php
                    $qtd = 0;
                    foreach ($evaluations as $evaluation) {
                         if ($evaluation['nota'] == "5") {
                              $qtd++;
                         }
                    } ?>
                    <div class="progress-bar" role="progressbar" style="width: <?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%;" aria-valuenow="<?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>" aria-valuemin="0" aria-valuemax="100"><?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%</div>
               </div>
               <span class="col-2 ms-3"><?php echo ($qtd == 1) ? "$qtd Avaliação" : "$qtd Avaliações" ?></span>
          </div>
     </div>
</div>
<div class="row mb-3">
     <div class="col">
          <div class="row d-flex flex-row align-items-baseline">
               <span class="col-2"><i class="bi bi-star-fill rating-color me-3"></i>4 Estrelas</span>
               <div class="col progress" style="padding: 0px !important;">
                    <?php
                    $qtd = 0;
                    foreach ($evaluations as $evaluation) {
                         if ($evaluation['nota'] == "4") {
                              $qtd++;
                         }
                    } ?>
                    <div class="progress-bar" role="progressbar" style="width: <?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%;" aria-valuenow="<?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>" aria-valuemin="0" aria-valuemax="100"><?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%</div>
               </div>
               <span class="col-2 ms-3"><?php echo ($qtd == 1) ? "$qtd Avaliação" : "$qtd Avaliações" ?></span>
          </div>
     </div>
</div>
<div class="row mb-3">
     <div class="col">
          <div class="row d-flex flex-row align-items-baseline">
               <span class="col-2"><i class="bi bi-star-fill rating-color me-3"></i>3 Estrelas</span>
               <div class="col progress" style="padding: 0px !important;">
                    <?php
                    $qtd = 0;
                    foreach ($evaluations as $evaluation) {
                         if ($evaluation['nota'] == "3") {
                              $qtd++;
                         }
                    } ?>
                    <div class="progress-bar" role="progressbar" style="width: <?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%;" aria-valuenow="<?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>" aria-valuemin="0" aria-valuemax="100"><?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%</div>
               </div>
               <span class="col-2 ms-3"><?php echo ($qtd == 1) ? "$qtd Avaliação" : "$qtd Avaliações" ?></span>
          </div>
     </div>
</div>
<div class="row mb-3">
     <div class="col">
          <div class="row d-flex flex-row align-items-baseline">
               <span class="col-2"><i class="bi bi-star-fill rating-color me-3"></i>2 Estrelas</span>
               <div class="col progress" style="padding: 0px !important;">
                    <?php
                    $qtd = 0;
                    foreach ($evaluations as $evaluation) {
                         if ($evaluation['nota'] == "2") {
                              $qtd++;
                         }
                    } ?>
                    <div class="progress-bar" role="progressbar" style="width: <?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%;" aria-valuenow="<?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>" aria-valuemin="0" aria-valuemax="100"><?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%</div>
               </div>
               <span class="col-2 ms-3"><?php echo ($qtd == 1) ? "$qtd Avaliação" : "$qtd Avaliações" ?></span>
          </div>
     </div>
</div>
<div class="row mb-5">
     <div class="col">
          <div class="row d-flex flex-row align-items-baseline">
               <span class="col-2"><i class="bi bi-star-fill rating-color me-3"></i>1 Estrelas</span>
               <div class="col progress" style="padding: 0px !important;">
                    <?php
                    $qtd = 0;
                    foreach ($evaluations as $evaluation) {
                         if ($evaluation['nota'] == "1") {
                              $qtd++;
                         }
                    } ?>
                    <div class="progress-bar" role="progressbar" style="width: <?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%;" aria-valuenow="<?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>" aria-valuemin="0" aria-valuemax="100"><?php echo ($qtd != 0) ? ($qtd / sizeof($evaluations)) * 100 : 0 ?>%</div>
               </div>
               <span class="col-2 ms-3"><?php echo ($qtd == 1) ? "$qtd Avaliação" : "$qtd Avaliações" ?></span>
          </div>
     </div>
</div>
<div class="input-group mb-3">
     <textarea id="comentario_servico" type="text" class="form-control" placeholder="Adicione um comentário..."></textarea>
     <button class="btn btn-outline-primary" type="button" id="btnAddComentario" onclick="adicionarComentarioServico(<?php echo $service['id'] ?>, <?php echo $_SESSION['idUsuario'] ?>)">Salvar</button>
</div>