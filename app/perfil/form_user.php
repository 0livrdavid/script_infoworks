<div class="row" style="margin-bottom: 1rem">
     <div class="col-6 section">
          <div class="row" style="gap: 1rem">
               <div class="col">
                    <h4 class="tema">Dados do Usuário</h4>
                    <label for="nome" class="form-label">Nome completo:</label>
                    <input name="nome" id="nome" class="form-control" type="text" value="<?php echo $_SESSION['usuario']['nome'] ?>" disabled>
                    <label for="cpf" class="form-label">CPF:</label>
                    <input name="cpf" id="cpf" class="form-control" type="text" value="<?php echo $_SESSION['usuario']['cpf'] ?>" disabled>
                    <label for="email" class="form-label">E-mail:</label>
                    <input name="email" id="email" class="form-control" type="text" value="<?php echo $_SESSION['usuario']['email'] ?>" disabled>
                    <label for="nascimento" class="form-label">Data de nascimento:</label>
                    <input name="nascimento" id="nascimento" class="form-control" type="text" value="<?php echo converte_data($_SESSION['usuario']['idade']) ?>" disabled>
               </div>
               <div class="col d-table" style="text-align: center;">
                    <h4 class="tema">Foto de Perfil</h4>
                    <div class="d-table-row" style="text-align: center;">
                         <img id="img_perfil" style="border-radius: 50%; object-fit: cover; width: 14rem" src="../../files/avatar/<?php echo (isset($_SESSION['usuario']['imagem_perfil'])) ? $_SESSION['usuario']['imagem_perfil'] : 'avatar.png'; ?>" alt="Perfil">
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-imagem-perfil">Imagem de Perfil</button>
               </div>
          </div>
     </div>

     <div class="col section">
          <h4 class="tema">Dados de Endereço</h4>
          <label for="cep" class="form-label">CEP:</label>
          <div class="input-group mb-3">
               <input type="text" name="cep" id="cep" class="form-control mask-cep" value="<?php echo $_SESSION['usuario']['cep'] ?>" placeholder="_____-___" aria-label="_____-___" aria-describedby="button-discovery-cep">
               <button class="btn btn-outline-primary" type="button" id="button-discovery-cep">Buscar CEP</button>
          </div>
          <div class="row">
               <div class="col">
                    <label for="cidade" class="form-label">Cidade:</label>
                    <select id="cidade" name="cidade" class="form-select">
                         <option value="">Selecione</option>
                    </select>
               </div>
               <div class="col">
                    <label for="estado" class="form-label">Estado:</label>
                    <select id="estado" name="estado" class="form-select">
                         <option value="">Selecione</option>
                         
                    </select>
               </div>
          </div>
          <div class="row">
               <div class="col-8">
                    <label for="rua" class="form-label">Rua:</label>
                    <input name="rua" id="rua" class="form-control" value="<?php echo $_SESSION['usuario']['rua'] ?>" type="text">
               </div>
               <div class="col">
                    <label for="numero" class="form-label">Número:</label>
                    <input name="numero" id="numero" class="form-control" value="<?php echo $_SESSION['usuario']['numero'] ?>" type="text">
               </div>
          </div>
          <label for="bairro" class="form-label">Bairro:</label>
          <input name="bairro" id="bairro" class="form-control" value="<?php echo $_SESSION['usuario']['bairro'] ?>" type="text">
     </div>
</div>

<div class="row">
     <div class="col-8 d-flex flex-column section">
          <h4 class="tema">Dados Pessoais</h4>
          <label for="sobre_mim" class="form-label">Fale sobre você:</label>
          <textarea name="sobre_mim" id="sobre_mim" class="form-control summernote" rows="10"><?php echo $_SESSION['usuario']['sobre_mim'] ?></textarea>
     </div>

     <div class="col section">
          <h4 class="tema">Dados de Contato</h4>
          <label for="telefone" class="form-label">Telefone:</label>
          <input name="telefone" id="telefone" class="form-control mask-telefone" type="text" placeholder="(__) 9____-____" value="<?php echo $_SESSION['usuario']['telefone'] ?>">
          <label for="whatsapp" class="form-label">Whatsapp:</label>
          <input name="whatsapp" id="whatsapp" class="form-control mask-telefone" type="text" placeholder="(__) 9____-____" value="<?php echo $_SESSION['usuario']['whatsapp'] ?>">
          <label for="instagram" class="form-label">Instagram:</label>
          <input name="instagram" id="instagram" class="form-control" type="text" placeholder="https://www.instagram.com/..." value="<?php echo $_SESSION['usuario']['instagram'] ?>">
          <label for="facebook" class="form-label">Facebook:</label>
          <input name="facebook" id="facebook" class="form-control" type="text" placeholder="https://www.facebook.com/..." value="<?php echo $_SESSION['usuario']['facebook'] ?>">
     </div>
</div>