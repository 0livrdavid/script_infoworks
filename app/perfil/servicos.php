<div id="<?php echo $service['id'] ?>" class="row">
    <div class="col section">
        <h4 class="tema"><?php echo $service['fk_idCategory'] ?></h4>
        <p><?php echo $service['descricao'] ?></p>
        <div style="display: flex; justify-content: space-between; flex-direction: row;">
            <div>
                <i class="bi bi-star-fill rating-color"></i>
                <i class="bi bi-star-fill rating-color"></i>
                <i class="bi bi-star-fill rating-color"></i>
                <i class="bi bi-star-fill rating-color"></i>
                <i class="bi bi-star-fill rating-color"></i>
                <p>5 - 33 Avaliações</p>
            </div>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-adicionar-servico" onclick="getServico(<?php echo $service['id'] ?>)">EDITAR</button>
                <a href="../servicos/?id=<?php echo $service['id'] ?>" target="_blank"><button class="btn btn-primary">ABRIR</button></a>
            </div>
        </div>
    </div>
</div>