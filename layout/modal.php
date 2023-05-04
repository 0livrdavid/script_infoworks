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
                <div class="modalMeio">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label for="nome" class="form-label">Nome do serviço</label>
                                <input id="nome" name="nome" class="form-control" type="text">
                                <label for="preco" class="form-label">Preço</label>
                                <input id="preco" name="preco" class="form-control" type="text">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select name="tipo" class="form-select">
                                    <option value="AC">KM</option>
                                    <option value="AL">Hora</option>
                                    <option value="AL">Dia</option>
                                </select>
                                <label for="nome" class="form-label">Descrição do serviço</label>
                                <textarea class="form-control"></textarea>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </div>
</div>