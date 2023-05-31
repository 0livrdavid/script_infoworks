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
                            <input id="servico_cpf" type="hidden" value="<?php echo $_SESSION['cpfUsuario'] ?>">
                            <label for="servico_categoria" class="form-label">Categoria:</label>
                            <select name="servico_categoria" id="servico_categoria" class="form-select">
                                <?php
                                $services_categoria = getServiceCategoria();
                                foreach ($services_categoria as $obj) {
                                    echo " <option value='{$obj['nome']}'>{$obj['nome']}</option>";
                                }
                                ?>
                            </select>
                            <label for="servico_preco" class="form-label">Preço:</label>
                            <input id="servico_preco" name="servico_preco" class="form-control mask-dinheiro" type="text" placeholder="R$ 0,00">
                            <label for="servico_tipo" class="form-label">Tipo de Preço:</label>
                            <select name="servico_tipo" id="servico_tipo" class="form-select">
                                <?php
                                $services_type = getServiceType();
                                foreach ($services_type as $obj) {
                                    echo " <option value='{$obj['tipo']}'>{$obj['tipo']}</option>";
                                }
                                ?>
                            </select>
                            <label for="servico_descricao" class="form-label">Descrição do serviço:</label>
                            <textarea id="servico_descricao" class="form-control" placeholder="Adicione sua Descrição aqui" rows="5"></textarea>
                            <label for="imagens[]" class="form-label">Inserir imagens</label>
                            <input class="form-control" type="file" id="servico_imagens" onchange="changeAccordionImage(this)" accept="image/png, image/jpeg" multiple>
                            <div class="accordion accordion-flush" id="accordion_image" style="margin-top: 15px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="criarServico()" data-bs-dismiss="modal">Adicionar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-imagem-perfil" tabindex="-1" aria-labelledby="modal-imagem-perfil-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-imagem-perfil-label">Imagem de Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <input id="perfil_cpf" type="hidden" value="<?php echo $_SESSION['cpfUsuario'] ?>">
                            <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
                                <img src="../../files/avatar/<?php echo (isset($_SESSION['usuario']['imagem_perfil'])) ? $_SESSION['usuario']['imagem_perfil'] : 'avatar.png'; ?>" id="img_input_perfil" style="width: 100%; object-fit: cover; max-width: 400px;">
                                <input id="img_input_perfil2" style="margin-top: 15px" class="form-control" type="file" onchange="changeInputImgToImg(this, 'img_input_perfil')" accept="image/png, image/jpeg">
                                <input id="img_input_perfil3" class="hidden" type="file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-crop-imagem" onclick="cloneImage('img_input_perfil', 'img_output'); initializeCropper(document.getElementById('img_output')); changeFunctionBtnCrop('img_input_perfil')">Cortar Imagem</button>
                <button type="button" class="btn btn-primary" onclick="salvarImagemPerfil()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-crop-imagem" tabindex="-1" aria-labelledby="modal-crop-imagem-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-crop-imagem-label">Cortar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div style="width: 100%; height: 300px;">
                                <img id="img_output">
                            </div>
                            <div style="width: 100%; margin-top: 15px">
                                <button type="button" class="btn btn-primary" onclick="turnAspectRatio('0')">Livre</button>
                                <button type="button" class="btn btn-primary" onclick="turnAspectRatio('1 / 1')">1 / 1</button>
                                <button type="button" class="btn btn-primary" onclick="turnAspectRatio('4 / 3')">4 / 3</button>
                                <button type="button" class="btn btn-primary" onclick="turnAspectRatio('16 / 9')">16x9</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="cropImageBtn" onclick="cropImage('img_input_perfil')" data-bs-dismiss="modal">Cortar Imagem</button>
            </div>
        </div>
    </div>
</div>