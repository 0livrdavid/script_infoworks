<div id="" class="modal">
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

<div class="modal fade" id="modal-sem-cadastro" tabindex="-1" aria-labelledby="modal-sem-cadastro-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-sem-cadastro-label">Você não está conectado!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modalMeio">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <p>Para ver mais informações do serviço ou informações de contato acesse a sua conta.</p>
                            </div>
                            <div class="col-6">
                                <img style="width: 100%" src="../../src/pictures/InfoWorks_logo.png" alt="Lights">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                Para continuar faça <a href="../login_cadastro/?page=login">LOGIN</a> ou <a href="../login_cadastro/?page=cadastro">CADASTRE-SE</a>.
            </div>
        </div>
    </div>
</div>


<div id="modal-adicionar-servico" class="modal">
    <div class="div-modal-content">
        <div class="tituloModal">
            <h1 style="font-size: 1.6rem; color: #ffffff !important;">Inserir novo serviço!</h1>
            <span class="close">&times;</span>
        </div>
        <div class="modalMeio">
            <div class="paragrafoModal">
                <h4>Nome do serviço</h4>
                <input type="text">
                <div class="preco">
                    <div class="pt1">
                        <h4>Preço</h4>
                        <input id="ipt-preco" type="text">
                    </div>
                    <div class="pt2">
                        <h4>Tipo</h4>
                        <select name="tipo">
                            <option value="AC">KM</option>
                            <option value="AL">Hora</option>
                            <option value="AL">Dia</option>
                        </select>
                    </div>
                </div>
                <h4>Descrição do serviço</h4>
                <textarea class="modal-input-servico"></textarea>
                <h4>Inserir imagens</h4>
            </div>
        </div>
        <div class="modalMeio">
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
        <div class="rodapeModal">
            <input class="btn btn-primary" type="submit" value="Inserir">
        </div>
    </div>
</div>