<?php
require_once '../../config.php';
//require_once '../../funcoes/FC_FuncoesBD.php';
//require_once '../../funcoes/FC_Sistema.php';
require_once '../../layout/start.php';
?>


<div class="content">
    <div class="container">
        <?php include "./header.php" ?>
        <?php include "./filter.php" ?>

        <div class="adverts">

            <?php
            //include "./card.php"
            ?>

            <div class="card">
                <div style="">
                    <div class="imgCargo">
                        <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>motorista.jpg" alt="Motorista" srcset="">
                    </div>
                    <div class="cargo">
                        <div class="cargoNome">
                            <h2 id="txt1">Motorista</h2>
                        </div>
                        <div class="cargoPreco">
                            <h2 id="txt2">R$10/Km</h2>
                        </div>
                    </div>
                    <div class="nome">
                        <h3>Carlos Henrique, 29 anos</h3>
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

            <div class="card">
                <div class="imgCargo">
                    <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>pintor.jpg" alt="Motorista" srcset="">
                </div>
                <div class="cargo">
                    <div class="cargoNome">
                        <h2 id="txt1">Pintor</h2>
                    </div>
                    <div class="cargoPreco">
                        <h2 id="txt2">R$100/Dia</h2>
                    </div>
                </div>
                <div class="nome">
                    <h3>Pedro Paulo, 35 anos</h3>
                </div>
                <div class="cidade">
                    <h3>Piranguinho - MG</h3>
                </div>
                <div class="avaliacao">
                    <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>estrela.png" alt="estrela" srcset="" height="25px">
                    <h4>3,7 - 74 Avaliações</h4>
                </div>
                <div class="button">
                    <input type="submit" value="Mais Detalhes">
                </div>
            </div>

            <div class="card">
                <div class="imgCargo">
                    <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>diarista.jpg" alt="Motorista" srcset="">
                </div>
                <div class="cargo">
                    <div class="cargoNome">
                        <h2 id="txt1">Diarista</h2>
                    </div>
                    <div class="cargoPreco">
                        <h2 id="txt2">R$20/Hora</h2>
                    </div>
                </div>
                <div class="nome">
                    <h3>Maria da Penha, 40 anos</h3>
                </div>
                <div class="cidade">
                    <h3>Pedralva - MG</h3>
                </div>
                <div class="avaliacao">
                    <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>estrela.png" alt="estrela" srcset="" height="25px">
                    <h4>4,1 - 15 Avaliações</h4>
                </div>
                <div class="button">
                    <input type="submit" value="Mais Detalhes">
                </div>
            </div>

            <div class="card">
                <div class="imgCargo">
                    <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>entregadora.png" alt="Motorista" srcset="">
                </div>
                <div class="cargo">
                    <div class="cargoNome">
                        <h2 id="txt1">Entregadora</h2>
                    </div>
                    <div class="cargoPreco">
                        <h2 id="txt2">R$150/Dia</h2>
                    </div>
                </div>
                <div class="nome">
                    <h3>Tamires Silva, 39 anos</h3>
                </div>
                <div class="cidade">
                    <h3>Piranguinho - MG</h3>
                </div>
                <div class="avaliacao">
                    <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>estrela.png" alt="estrela" srcset="" height="25px">
                    <h4>4,1 - 12 Avaliações</h4>
                </div>
                <div class="button">
                    <input type="submit" value="Mais Detalhes">
                </div>
            </div>

            <div class="card">
                <div class="imgCargo">
                    <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>baba.jpg" alt="Baba" srcset="">
                </div>
                <div class="cargo">
                    <div class="cargoNome">
                        <h2 id="txt1">Babá</h2>
                    </div>
                    <div class="cargoPreco">
                        <h2 id="txt2">R$30/Dia</h2>
                    </div>
                </div>
                <div class="nome">
                    <h3>Juliana Pereira, 27 anos</h3>
                </div>
                <div class="cidade">
                    <h3>Pedralva - MG</h3>
                </div>
                <div class="avaliacao">
                    <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>estrela.png" alt="estrela" srcset="" height="25px">
                    <h4>2,3 - 55 Avaliações</h4>
                </div>
                <div class="button">
                    <input type="submit" value="Mais Detalhes">
                </div>
            </div>

            <div class="card">
                <div class="imgCargo">
                    <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>motoboy.webp" alt="Baba" srcset="">
                </div>
                <div class="cargo">
                    <div class="cargoNome">
                        <h2 id="txt1">Motoboy</h2>
                    </div>
                    <div class="cargoPreco">
                        <h2 id="txt2">R$15/km</h2>
                    </div>
                </div>
                <div class="nome">
                    <h3>Yuri Ramos, 20 anos</h3>
                </div>
                <div class="cidade">
                    <h3>Maria da Fé - MG</h3>
                </div>
                <div class="avaliacao">
                    <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>estrela.png" alt="estrela" srcset="" height="25px">
                    <h4>4,7 - 63 Avaliações</h4>
                </div>
                <div class="button">
                    <input type="submit" value="Mais Detalhes">
                </div>
            </div>

            <div class="card">
                <div class="imgCargo">
                    <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>jardineiro.png" alt="Baba" srcset="">
                </div>
                <div class="cargo">
                    <div class="cargoNome">
                        <h2 id="txt1">Jardineiro</h2>
                    </div>
                    <div class="cargoPreco">
                        <h2 id="txt2">R$30/Hora</h2>
                    </div>
                </div>
                <div class="nome">
                    <h3>Pedro Silva, 32 anos</h3>
                </div>
                <div class="cidade">
                    <h3>Itajubá - MG</h3>
                </div>
                <div class="avaliacao">
                    <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>estrela.png" alt="estrela" srcset="" height="25px">
                    <h4>2,5 - 12 Avaliações</h4>
                </div>
                <div class="button">
                    <input type="submit" value="Mais Detalhes">
                </div>
            </div>

            <div class="card">
                <div class="imgCargo">
                    <img class="imagem" src="<?php echo URL_BASE_ASSETS_PICTURES; ?>carpinteiro.png" alt="Baba" srcset="">
                </div>
                <div class="cargo">
                    <div class="cargoNome">
                        <h2 id="txt1">Carpinteiro</h2>
                    </div>
                    <div class="cargoPreco">
                        <h2 id="txt2">R$120/Dia</h2>
                    </div>
                </div>
                <div class="nome">
                    <h3>Sérgio Alcantara, 50 anos</h3>
                </div>
                <div class="cidade">
                    <h3>Itajubá - MG</h3>
                </div>
                <div class="avaliacao">
                    <img src="../../src/pictures/estrela.png" alt="estrela" srcset="" height="25px">
                    <h4>3,9 - 28 Avaliações</h4>
                </div>
                <div class="button">
                    <input type="submit" value="Mais Detalhes">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URL_BASE_ASSETS_JAVASCRIPT; ?>dashboard/dashboard.js"></script>

<?php
require PATH_ASSETS_END;
?>
