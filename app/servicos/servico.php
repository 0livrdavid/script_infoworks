<?php 
require_once '../../config.php';
componentPhpFile();
?>

<div class="section">
    <h3><?php echo $service['fk_idCategory'] ?></h3>
    <div id="<?php echo $service['id'] ?>" class="row" style="margin-top: 30px;">
        <div class="col" s>
            <div id="carousel_id_<?php echo $service['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php
                    $images = getFilesService($service['id']);
                    if (count($images)) {
                        foreach ($images as $image_key => $image) {
                            $active = "";
                            if ($image_key == 0) $active = "class=\"active\" aria-current=\"true\""; ?>
                            <button type="button" data-bs-target="#carousel_id_<?php echo $service['id'] ?>" data-bs-slide-to="<?php echo $image_key ?>" <?php echo $active ?> aria-label="<?php echo $image['filename'] ?>"></button>
                    <?php }
                    } ?>
                </div>
                <div class="carousel-inner">
                    <?php
                    $images = getFilesService($service['id']);
                    if (count($images)) {
                        foreach ($images as $image_key => $image) {
                            $active = "";
                            if ($image_key == 0) $active = "active"; ?>
                            <div class="carousel-item <?php echo $active ?>">
                                <img src="../../files/service/<?php echo $image['filename'] . getTypeFile($image['filetype'], true) ?>" class="d-block w-100" alt="<?php echo $image['filename'] ?>">
                            </div>
                    <?php }
                    } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel_id_<?php echo $service['id'] ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel_id_<?php echo $service['id'] ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
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