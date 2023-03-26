<div class="card">
    <div style="">
        <div class="imgCargo">
            <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>motorista.jpg" alt="Motorista" srcset="">
        </div>
        <div class="cargo">
            <div class="cargoNome">
                <h2 id="txt1"><?php echo $dado['categoria'] ?></h2>
            </div>
            <div class="cargoPreco">
                <h2 id="txt2"><?php echo "R$".$dado['valor']."/".$dado['tipoValor']?></h2>
            </div>
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
        <div class="button">
            <input type="submit" value="Mais Detalhes">
        </div>
    </div>
</div>
