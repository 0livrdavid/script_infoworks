<div id="<?php echo $service['id'] ?>" class="row">
    <h1>Meus Serviços</h1>
    <div class="col section">
        <div>
            <div>
                <h2><?php echo $service['fk_idCategory'] ?></h2>
                <p id="meuParagrafo"><?php echo $service['descricao'] ?></p>
            </div>
            <div>
                <i class="bi bi-star-fill rating-color"></i>
                <i class="bi bi-star-fill rating-color"></i>
                <i class="bi bi-star-fill rating-color"></i>
                <i class="bi bi-star-fill rating-color"></i>
                <i class="bi bi-star-fill rating-color"></i>
                <p>5 - 33 Avaliações</p>
            </div>
            <div>
                <a href="../servicos/?id=<?php echo $service['id'] ?>"><input class="botaoPe" type="submit" value="MAIS DETALHES"></a>
            </div>
        </div>
    </div>
</div>