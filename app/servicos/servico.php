<div class="section">
     <h3 class="tema"><?php echo $service['fk_idCategory'] ?></h3>
     <div id="<?php echo $service['id'] ?>" class="row" style="margin-top: 30px;">
          <div class="col">
               <?php include './carrosel.php' ?>
          </div>
          <div class="col">
               <h3 class="tema">Dados Pessoais</h3>
               <>
               <ul style="padding-left: 0;">
                    <li><i class="bi bi-whatsapp"></i><span style="margin-left: 10px;"><?php echo $user['whatsapp'] ?></span></li>
                    <li><i class="bi bi-instagram"></i><span style="margin-left: 10px;"><?php echo $user['instagram'] ?></span></li>
                    <li><i class="bi bi-envelope-at"></i><span style="margin-left: 10px;"><?php echo $user['email'] ?></span></li>
               </ul>
          </div>
     </div>
     <div class="row" style="margin-top: 30px;">
          <p id="meuParagrafo"><?php echo $service['descricao'] ?></p>
     </div>
</div>