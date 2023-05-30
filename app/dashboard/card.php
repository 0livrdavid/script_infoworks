<?php 
require_once '../../config.php';
componentPhpFile();
?>

<div id="<?php echo "card_id_" . $key ?>" class="card">
    <div class="div-card">
        <div class="imgCargo">
            <div id="carousel_id_<?php echo $key ?>" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php
                    $images = getFilesService($card['id']);
                    if (count($images)) {
                        foreach ($images as $image_key => $image) {
                            $active = "";
                            if ($image_key == 0) $active = "class=\"active\" aria-current=\"true\""; ?>
                            <button type="button" data-bs-target="#carousel_id_<?php echo $key ?>" data-bs-slide-to="<?php echo $image_key ?>" <?php echo $active ?> aria-label="<?php echo $image['filename'] ?>"></button>
                    <?php }
                    } ?>
                </div>
                <div class="carousel-inner">
                    <?php
                    $images = getFilesService($card['id']);
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
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel_id_<?php echo $key ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel_id_<?php echo $key ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <p class="cargoNome" title="<?php echo $card['categoria'] ?>"><?php echo $card['categoria'] ?></p>
        <p class="cargoPreco" title="<?php echo $card['valor'] . " / " . $card['tipoValor'] ?>"><?php echo $card['valor'] . " / " . $card['tipoValor'] ?></p>
        <p class="nome" title="<?php echo resume_nome($card['nome']) . ", " . calcularIdade($card['idade']) ?>"><?php echo resume_nome($card['nome']) . ", " . calcularIdade($card['idade']) ?></p>
        <p>Itajubá - MG</p>
        <div class="avaliacao">
            <i class="bi bi-star-fill rating-color"></i>
            <p>4,5 - 33 Avaliações</p>
        </div>
        <button href="#" class="button" onclick="abrirModal('modal-sem-cadastro')">Mais Detalhes</button>
    </div>
</div>