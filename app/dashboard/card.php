<div id="<?php echo $dado['card_id'] ?>" class="card">
    <div class="div-card">
        <div class="imgCargo">
            <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>motorista.jpg" alt="Motorista" srcset="">
        </div>
        <div class="cargo">
            <p class="cargoNome" title="<?php echo $dado['categoria'] ?>"><?php echo $dado['categoria'] ?></p>
            <p class="cargoPreco" title="<?php echo "R$".$dado['valor']."/".$dado['tipoValor']?>"><?php echo "R$".$dado['valor']."/".$dado['tipoValor']?></p>
        </div>
        <p class="nome" title="<?php echo $dado['nome'].", ".$dado['idade'] ?>"><?php echo $dado['nome'].", ".$dado['idade'] ?></p>
        <p>Itajubá - MG</p>
        <div class="avaliacao">
            <i class="bi bi-star-fill rating-color"></i><p>4,5 - 33 Avaliações</p>
        </div>
        <button href="#" class="button" onclick="abrirModal('modal-sem-cadastro')">Mais Detalhes</button>
    </div>
</div>
