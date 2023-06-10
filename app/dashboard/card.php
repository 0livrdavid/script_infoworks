<div id="<?php echo "card_id_" . $card['id'] ?>" class="card" style="width: 18rem; ">
    <div class="div-card">
        <div class="imgCargo">
            <?php include './carrosel.php' ?>
        </div>
        <p class="cargoNome" title="<?php echo $card['categoria'] ?>"><?php echo $card['categoria'] ?></p>
        <p class="cargoPreco" title="<?php echo $card['valor'] . " / " . $card['tipoValor'] ?>"><?php echo $card['valor'] . " / " . $card['tipoValor'] ?></p>
        <p class="nome" title="<?php echo resume_nome($card['nome']) . ", " . calcularIdade($card['idade']) ?>"><?php echo resume_nome($card['nome']) . ", " . calcularIdade($card['idade']) ?></p>
        <p>Itajubá - MG</p>
        <div class="avaliacao">
            <i class="bi bi-star-fill rating-color"></i>
            <p>4,5 - 33 Avaliações</p>
        </div>
        <?php
        if ($isLogged) {
            echo "<button href=\"javascript:;\" class=\"button\" onclick=\"window.location.href='../servicos/?id={$card['id']}'\">Mais Detalhes</button>";
        } else {
            echo "<button href=\"javascript:;\" class=\"button\" onclick=\"abrirModal('modal-sem-cadastro')\">Mais Detalhes</button>";
        }
        ?>
    </div>
</div>