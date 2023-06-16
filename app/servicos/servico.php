<div class="section">
     <h2 class="tema mb-3"><?php echo $service['fk_idCategory'] ?></h2>
     <div id="<?php echo $service['id'] ?>" class="row mb-3">
          <div class="col">
               <?php include './carrosel.php' ?>
          </div>
          <div class="col">
               <h4 class="tema mb-3">Dados Pessoais</h4>
               <p style="font-weight: 100; font-size: 1.2rem" </h5><?php echo ($user['sobre_mim'] != "") ? $user['sobre_mim'] : "O usuário não possui uma descrição pessoal."; ?></p>
               <hr>
               <h4 class="tema mb-3">Dados de Contato</h4>
               <ul style="padding-left: 0;">
                    <?php if ($user['telefone'] != "") { ?><li style="list-style: none;"><i class="bi bi-telephone"></i><span style="margin-left: 10px;"><?php echo $user['telefone'] ?></span></li><?php } ?>
                    <?php if ($user['whatsapp'] != "") { ?><li style="list-style: none;"><i class="bi bi-whatsapp"></i><span style="margin-left: 10px;"><a href="https://api.whatsapp.com/send?phone=<?php echo $user['whatsapp'] ?>"><?php echo $user['whatsapp'] ?></a></span></li><?php } ?>
                    <?php if ($user['instagram'] != "") { ?><li style="list-style: none;"><i class="bi bi-instagram"></i><span style="margin-left: 10px;"><a href="<?php echo $user['instagram'] ?>"><?php echo $user['instagram'] ?></a></span></li><?php } ?>
                    <?php if ($user['email'] != "") { ?><li style="list-style: none;"><i class="bi bi-envelope"></i><span style="margin-left: 10px;"><a href="mailto:<?php echo $user['email'] ?>"><?php echo $user['email'] ?></a></span></li><?php } ?>
               </ul>
          </div>
     </div>
     <div class="row mb-3">
          <div class="col">
               <h4 class="tema mb-3">Descrição do Serviço</h4>
               <p><?php echo $service['descricao'] ?></p>
          </div>
     </div>
     <div class="row">
          <div class="col">
               <?php
               $evaluations = sanitize_array(getEvaluations($service['id']));
               include './avaliacao.php' ?>
          </div>
     </div>
     <hr>
     <div class="row">
          <div class="col">
               <?php
               $comments = sanitize_array(getComments($service['id']));

               if (count($comments)) {
                    foreach ($comments as $key => $obj) {
                         $image = getImageProfileUser($obj['idUsuario']);
                         include "./comentario.php";
                    }
               } else { ?>
                    <h3 style="color: #ffffff">Não existem comentários cadastrados!</h3>
               <?php } ?>
          </div>
     </div>
</div>