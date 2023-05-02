<div class="row" style="margin-bottom: 1rem">
    <div class="col section">
        <div class="row" style="gap: 1rem">
            <div class="col">
                <h4>Dados do Usuário</h4>
                <label for="nome" class="form-label">Nome completo:</label>
                <input name="nome" id="nome" class="form-control" type="text" value="Josimar Ferreira" disabled>
                <label for="cpf" class="form-label">CPF:</label>
                <input name="cpf" id="cpf" class="form-control" type="text" value="123.456.789-90" disabled>
                <label for="email" class="form-label">E-mail:</label>
                <input name="email" id="email" class="form-control" type="text" value="josimar.ferreira@gmail.com" disabled>
                <label for="nascimento" class="form-label">Data de nascimento:</label>
                <input name="nascimento" id="nascimento" class="form-control" type="text" value="12/03/1997" disabled>
            </div>
            <div class="col d-table">
                <h4 class="">Foto de Perfil</h4>
                <div class="d-table-row" style="text-align: center;">
                    <img style="border-radius: 50%;" src="../../src/pictures/pessoa.jfif" alt="Perfil">
                </div>
                <input class="form-control" type="file" id="formFile">
            </div>
        </div>
    </div>

    <div class="col section">
        <h4>Dados de Endereço</h4>
        <label for="cep" class="form-label">CEP:</label>
        <input name="cep" id="cep" class="form-control" type="text">
        <div class="row">
            <div class="col">
                <label for="rua" class="form-label">Rua:</label>
                <input name="rua" id="rua" class="form-control"  type="text">
                <label for="cidade" class="form-label">Cidade:</label>
                <input name="cidade" id="cidade" class="form-control"  type="text">
            </div>
            <div class="col">
                <label for="numero" class="form-label">Número:</label>
                <input name="numero" id="numero" class="form-control"  type="text">
                <label for="estado" class="form-label">Estado:</label>
                <select id="estado" name="estado" class="form-select">
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                    <option value="EX">Estrangeiro</option>
                </select>
            </div>
        </div>
        <label for="bairro" class="form-label">Bairro:</label>
        <input name="bairro" id="bairro" class="form-control"  type="text">
    </div>
</div>

<div class="row">
    <div class="col-7 section">
        <h4>Dados Pessoais</h4>
        <label for="sobre" class="form-label">Fale sobre você:</label>
        <textarea name="sobre" id="sobre" class="form-control" rows="5"> </textarea>
        <label for="formacao" class="form-label">Formação:</label>
        <textarea name="formacao" id="formacao" class="form-control" rows="5"> </textarea>
    </div>

    <div class="col section">
        <h4>Dados de Contato</h4>
        <label for="telefone" class="form-label">Telefone:</label>
        <input name="telefone" id="telefone" class="form-control" type="text">
        <label for="whatsapp" class="form-label">Whatsapp:</label>
        <input name="whatsapp" id="whatsapp" class="form-control" type="text">
        <label for="instagram" class="form-label">Instagram:</label>
        <input name="instagram" id="instagram" class="form-control" type="text">
        <label for="facebook" class="form-label">Facebook:</label>
        <input name="facebook" id="facebook" class="form-control" type="text">
    </div>
</div>




