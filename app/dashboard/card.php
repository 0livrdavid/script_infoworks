<div class="card">
    <div class="div-card">
        <div class="imgCargo">
            <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>motorista.jpg" alt="Motorista" srcset="">
        </div>
        <div class="cargo">
            <h2 class="cargoNome"><?php echo $dado['categoria'] ?></h2>
            <h2 class="cargoPreco"><?php echo "R$".$dado['valor']."/".$dado['tipoValor']?></h2>
        </div>
        <div class="nome">
            <h3><?php echo $dado['nome'].", ".$dado['idade'] ?></h3>
        </div>
        <div class="cidade">
            <h3>Itajubá - MG</h3>
        </div>
        <div class="avaliacao">
            <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>estrela.png" alt="estrela" srcset="" height="25px">
            <h4>4,5 - 33 Avaliações</h4>
        </div>
        <a href="#" class="button">Mais Detalhes</a>
    </div>
</div>
