<div class="section">
     <h2 class="tema"><?php echo $service['fk_idCategory'] ?></h2>
     <div id="<?php echo $service['id'] ?>" class="row" style="margin-top: 30px;">
          <div class="col">
               <?php include './carrosel.php' ?>
          </div>
          <div class="col">
               <h4 class="tema">Dados Pessoais</h4>
               <h5 style="font-weight: 100;" </h5><?php echo ($user['sobre_mim'] != "") ? $user['sobre_mim'] : "O usuário não possui uma descrição pessoal."; ?></h5>
               <hr>
               <h4 class="tema">Dados de Contato</h4>
               <ul style="padding-left: 0;">
                    <?php if ($user['whatsapp'] != "") { ?><li><i class="bi bi-whatsapp"></i><span style="margin-left: 10px;"><?php echo $user['whatsapp'] ?></span></li><?php } ?>
                    <?php if ($user['instagram'] != "") { ?><li><i class="bi bi-instagram"></i><span style="margin-left: 10px;"><?php echo $user['instagram'] ?></span></li><?php } ?>
                    <?php if ($user['email'] != "") { ?><li><i class="bi bi-envelope-at"></i><span style="margin-left: 10px;"><?php echo $user['email'] ?></span></li><?php } ?>
               </ul>
          </div>
     </div>
     <div class="row" style="margin-top: 30px;">
          <h4 class="tema">Descrição do Serviço</h4>
          <p id="meuParagrafo"><?php echo $service['descricao'] ?></p>
          <h4 class="tema">Avaliação</h4>
     </div>
</div>