<div id="modal-sem-cadastro" class="modal">
    <div class="div-modal-content">
        <div class="tituloModal">
            <h1 style="font-size: 1.6rem; color: #ffffff !important;">Você não está conectado!</h1>
            <span class="close">&times;</span>
        </div>
        <div class="modalMeio">
            <div class="paragrafoModal">
                <p>Para ver mais informações do serviço ou informações de contato acesse a sua conta.</p>
            </div>
            <div class="imgModal">
                <img src="../../src/pictures/InfoWorks_logo.png" alt="Lights">
            </div>
        </div>
        <div class="rodapeModal">
            Para continuar faça <a href="../login_cadastro/?page=login">LOGIN</a> ou <a href="../login_cadastro/?page=cadastro">CADASTRE-SE</a>.
        </div>
    </div>
</div>

<div class="modal fade" id="modal-adicionar-servico" tabindex="-1" aria-labelledby="modal-adicionar-servico-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-adicionar-servico-label">Inserir novos serviços!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <input id="servico_idusuario" type="hidden" value="<?php echo $_SESSION['idUsuario'] ?>">
                            <label for="servico_categoria" class="form-label">Categoria:</label>
                            <select name="servico_categoria" class="form-select">
                                <?php 
                                $services_categoria = getServiceCategoria();
                                foreach ($services_categoria as $obj) {
                                    echo " <option value='{$obj['nome']}'>{$obj['nome']}</option>"
;                                    }
                                ?>
                            </select>
                            <label for="servico_preco" class="form-label">Preço:</label>
                            <input id="servico_preco" name="servico_preco" class="form-control" type="number" placeholder="Preço">
                            <label for="servico_tipo" class="form-label">Tipo de Preço:</label>
                            <select name="servico_tipo" class="form-select">
                                <?php 
                                $services_type = getServiceType();
                                foreach ($services_type as $obj) {
                                    echo " <option value='{$obj['tipo']}'>{$obj['tipo']}</option>"
;                                    }
                                ?>
                            </select>
                            <label for="nome" class="form-label">Descrição do serviço:</label>
                            <textarea class="form-control" placeholder="Adicione sua Descrição aqui"></textarea>
                            <label for="imagens" class="form-label">Inserir imagens</label>
                            <div class="upload">
                                <p>Drag files here or <span class="upload__button">Browse</span></p>
                            </div>
                            <!-- <div class="uploaded uploaded--one">
                                <i class="far fa-file-pdf"></i>
                                <div class="file">
                                    <div class="file__name">
                                        <p>lorem_ipsum.pdf</p>
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:100%"></div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="imgs">
                                <button class="btn-img" onclick="openFile()">
                                    <img src="pictures/input-img.png" alt="Selecionar Imagens">
                                </button>
                                <button class="btn-img" onclick="openFile()">
                                    <img src="pictures/input-img.png" alt="Selecionar Imagens">
                                </button>
                                <button class="btn-img" onclick="openFile()">
                                    <img src="pictures/input-img.png" alt="Selecionar Imagens">
                                </button>
                                <button class="btn-img" onclick="openFile()">
                                    <img src="pictures/input-img.png" alt="Selecionar Imagens">
                                </button>
                                <button class="btn-img" onclick="openFile()">
                                    <img src="pictures/input-img.png" alt="Selecionar Imagens">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="criarServico()">Adicionar</button>
            </div>
        </div>
    </div>
</div>