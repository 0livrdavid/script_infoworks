<div class="section">
    <h3 class="tema"><?php echo $service['fk_idCategory'] ?></h3>
    <div id="<?php echo $service['id'] ?>" class="row" style="margin-top: 30px;">
        <div class="col">
            <?php include './carrosel.php' ?>
        </div>
        <div class="col">
            <h3><?php echo $service['fk_idCategory'] ?></h3>
            <div style="display: flex; justify-content: space-between; flex-direction: row;">
                
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 30px;">
        <p id="meuParagrafo"><?php echo $service['descricao'] ?></p>
    </div>
</div>