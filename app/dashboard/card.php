<div class="card">
    <div class="div-card">
        <div class="imgCargo">
            <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>motorista.jpg" alt="Motorista" srcset="">
        </div>
        <div class="cargo">
            <h2 class="cargoNome" title="<?php echo $dado['categoria'] ?>"><?php echo $dado['categoria'] ?></h2>
            <h2 class="cargoPreco" title="<?php echo "R$".$dado['valor']."/".$dado['tipoValor']?>"><?php echo "R$".$dado['valor']."/".$dado['tipoValor']?></h2>
        </div>
        <div>
            <h3 class="nome" title="<?php echo $dado['nome'].", ".$dado['idade'] ?>"><?php echo $dado['nome'].", ".$dado['idade'] ?></h3>
        </div>
        <div class="cidade">
            <h3>Itajubá - MG</h3>
        </div>
        <div class="avaliacao">
            <i class="bi bi-star-fill rating-color"></i><h4>4,5 - 33 Avaliações</h4>
        </div>
        <a href="#" class="button" onclick="abrirModal('modal-sem-cadastro')">Mais Detalhes</a>
    </div>
</div>
