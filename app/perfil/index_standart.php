<?php
require_once '../../config.php';
require_once '../../layout/start.php';
require_once '../../ajax/perfil/perfil.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Unset the session variable
    session_destroy();

    // Redirect to the same page to prevent form resubmission
    header('Location: ../dashboard/');
    exit;
}
?>

<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="pt-br" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>InfoWorks - Perfil</title>
  <link rel="icon" type="image/x-icon" href="../../src/pictures/InfoWorks_logo_fundo.ico">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  margin: 0;
  padding: 0;
  background: #f2f2f2;
  height: 100vh;
  overflow: auto;
}

.divPrincipal {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: repeat(2, 1fr);
  max-width: 1660px;
  margin: auto;
  gap: 50px;
}

.button-value {
  border: 2px solid #3b2b83;
  padding: 0.5em 1em;
  border-radius: 3em;
  background-color: transparent;
  color: #3b2b83;
  cursor: pointer;
}

.active {
  background-color: #3b2b83;
  color: #ffffff;
}


.dados-endereco {
  padding: 10px;
  border-radius: 10px;
  box-sizing: border-box;
  left: 0;
  bottom: 0;
}

.divPrincipal input,
textarea,
select {
  flex: 1;
  padding: 10px;
  border: 4px solid #c5c5c5;
  border-radius: 25px;
  font-size: 23px;
  outline: none;
  background-color: transparent;
  color: black;
  resize: none;
  overflow: hidden;
  margin-bottom: 7px;
}

.conta-input {
  width: 750px;
  height: 140px;
  line-height: 1.5;
}

.divPrincipal h3 {
  font-size: 32px;
  color: #3b2b83;
  margin-left: 10px;
}

.divPrincipal h4 {
  font-size: 25px;
}

.titulo-pag {
  max-width: 1660px;
  margin: 0 auto;
  padding: 25px;
  font-size: 25px;
}

.dados-conta {
  padding: 10px;
  border-radius: 10px;
  box-sizing: border-box;
  margin-top: 0px;
  margin-right: 0px;
}

.dados-contato {

  padding: 10px;
  border-radius: 10px;
  box-sizing: border-box;
  right: 0;
  bottom: 0;
}

.dados-usuario {
  display: flex;
}

.dados-usuario-foto {
  margin: 0 auto;
  text-align: center;
  line-height: 80px;
}

.dados-usuario-foto img {
  border-radius: 50%;
}

#botaoFoto {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  padding: 0;
  margin: 0 auto;
  border: 2px solid #3b2b83;
  padding: 0.5em 1em;
  border-radius: 3em;
  background-color: #3b2b83;
  color: #ffffff;
  cursor: pointer;
  font-size: 16px;
}


.sectionUsuario {
  grid-row: 1 / 2;
  grid-column: 1 / 2;
  border-radius: 20px;
  box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
  background-color: #ffffff;
  padding: 10px;
}

.sectionConta {
  grid-row: 1 / 2;
  grid-column: 2 / 3;
  border-radius: 20px;
  box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
  background-color: #ffffff;
  padding: 10px;
}

.sectionEndereco {
  grid-row: 2 / 3;
  grid-column: 1 / 2;
  border-radius: 20px;
  box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
  background-color: #ffffff;
  padding: 10px;
}

.sectionContato {
  grid-row: 2 / 3;
  grid-column: 2 / 3;
  border-radius: 20px;
  box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
  background-color: #ffffff;
  padding: 10px;
}


.dados-usuario-form {
  padding: 10px;
  border-radius: 10px;
  box-sizing: border-box;
  top: 0;
  left: 0;
}

.cabecalho {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 0 auto;
  background-color: rgb(130, 179, 243);
  max-width: 1660px;
  border-radius: 15px;
  box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
  margin-top: 10px;
}

.img_logo img {
  margin-left: 50px;
  height: 50px;
}

.botao-noti {
  cursor: pointer;
  width: 25px;
  height: 25px;
  background-color: transparent;
  display: flex;
  justify-content: center;
  border: none;
  align-items: center;
}

.caixa-busca {
  display: flex;
  border-radius: 25px;
  overflow: hidden;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  background-color: #fff;
}

.caixa-busca input[type="text"] {
  flex: 1;
  padding: 10px;
  border: none;
  border-radius: 25px 0 0 25px;
  font-size: 16px;
  outline: none;
}

.caixa-busca button[type="submit"] {
  padding: 10px 20px;
  border: none;
  background-color: #3b2b83;
  color: #fff;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.caixa-busca button[type="submit"]:hover {
  background-color: #3b2b83;
}


.botao-noti img {
  max-width: 100%;
  max-height: 100%;
  object-fit: cover;
  object-position: center bottom;
}

.botao-circular {
  cursor: pointer;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: none;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: transparent;
  margin-top: 10px;
  margin-bottom: 10px;
}

.botao-circular img {
  max-width: 100%;
  max-height: 100%;
  border-radius: 50%;
  object-fit: cover;
  object-position: center bottom;
  /* ajusta a posição da imagem dentro do botão */
}

.perfil {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-right: 15px;
}

.notifica {
  justify-content: center;
  align-items: center;
  margin-right: 15px;
}

.logo {
  margin-left: 5px;
}

.pesquisa {
  margin-left: 30px;
}

.cabecalho-p1 {
  display: flex;
  justify-content: center;
  align-items: center;
}

.cabecalho-p2 {
  display: flex;
  justify-content: center;
  align-items: center;
}

#txtFotoPerfil {
  font-size: 25px;
  color: #000000;
  margin-left: 5px;
}

.sectionEnderecoP1 {
  display: flex;
  justify-content: space-between;
}

.SEP2 input {
  width: 270px;
  line-height: 1.5;
  margin-right: 10px;
}

.sectionEnderecoP2 {
  display: flex;
  justify-content: space-between;
}


.SEP4 select {
  width: 270px;
  line-height: 1.5;
  margin-right: 10px;
}

.footer {
  max-width: 1660px;
  margin: 0 auto;
  margin-top: 25px;
  position: left;
  text-align: right;
}

.botaoPe {
  width: 220px;
  height: 50px;
  border: 2px solid #3b2b83;
  border-radius: 3em;
  background-color: #3b2b83;
  color: #ffffff;
  cursor: pointer;
  font-size: 20px;
  margin-left: 10px;
  width: 100%;
}

.botaoPe2 {
  width: 220px;
  height: 50px;
  border: 2px solid #ff0000;
  border-radius: 3em;
  background-color: #ff000000;
  color: #ff0000;
  cursor: pointer;
  width: 100%;
  font-size: 20px;
  margin-left: 10px;
}
  </style>
</head>

<body>
  <div class="cabecalho">
    <div class="cabecalho-p1">

      <div class="logo">
        <div class="img_logo">
          <!-- <img src="pictures/InfoWorks_logo.png" alt="" srcset=""> -->
          <a href="home.html"><img src="../../src/pictures/InfoWorks_logo.png" alt=""></a>
        </div>
      </div>

      <div class="pesquisa">
        <div class="caixa-busca">
          <input type="text" placeholder="Digite sua pesquisa...">
          <button type="submit">Pesquisar</button>
        </div>
      </div>

    </div>

    <!-- <div class="cabecalho-p1.5">
      <a href="home.html"> <input class="botaoPe" type="submit" value="Início"></a>
      <a href="perfil.html"> <input class="botaoPe" type="submit" value="Perfil"></a>
    </div> -->

    <div class="cabecalho-p2">
      <div class="notifica">
        <button class="botao-noti">
          <img src="../../src/pictures/notification.png" alt="Notificações">
        </button>
      </div>
      <p style="color: #fff; margin: 0 15px"><?php echo $_SESSION['usuario']['nome'] ?></p>
      <div class="perfil">
        <div class="fotoPerfil">
          <button class="botao-circular">
            <!-- <img src="pictures/pessoa.jfif" alt="Perfil">  Anterior -->
            <a href="perfil.html"><img src="../../src/pictures/pessoa.jfif" alt="Perfil"></a> <!-- Foto subiu rs -->
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="titulo-pag">
    <h1>Perfil</h1>
  </div>


  <div class="divPrincipal">

    <div class="sectionUsuario">

      <div class="dados-usuarios-titulo">
        <h3>Dados do Usuário</h3>
      </div>

      <div class="dados-usuario">
        <div class="dados-usuario-form">
          <h4>Nome completo:</h4>
          <input type="text" value="Josimar Ferreira" disabled>
          <h4>CPF:</h4>
          <input type="text" value="123.456.789-90" disabled>
          <h4>Data de nascimento:</h4>
          <input type="text" value="12/03/1997" disabled>
          <h4>E-mail:</h4>
          <input type="text" value="josimar.ferreira@gmail.com" disabled>
        </div>

        <div class="dados-usuario-foto">
          <h3 id="txtFotoPerfil">Foto de Perfil</h3>
          <img src="../../src/pictures/pessoa.jfif" alt="Perfil">
          <input id="botaoFoto" type="button" value="Carregar foto">
        </div>
      </div>


    </div>

    <div class="sectionConta">
      <div class="dados-conta-titulo">
        <h3>Dados Pessoais</h3>
      </div>
      <div class="dados-conta">
        <h4>Fale sobre você:</h4>
        <textarea class="conta-input" maxlength="250"> </textarea>
        <h4>Formação:</h4>
        <textarea class="conta-input" maxlength="250"> </textarea>
      </div>
    </div>


    <div class="sectionEndereco">
      <div class="dados-endereco-titulo">
        <h3>Dados de Endereço</h3>
      </div>

      <div class="dados-endereco">
        <h4>CEP:</h4>
        <input type="text">

        <div class="sectionEnderecoP1">

          <div class="SEP1">
            <h4>Rua:</h4>
            <input type="text">
          </div>
          <div class="SEP2">
            <h4>Número:</h4>
            <input type="text">
          </div>

        </div>

        <div class="sectionEnderecoP2">

          <div class="SEP3">
            <h4>Cidade:</h4>
            <input type="text">

          </div>

          <div class="SEP4">
            <h4>Estado:</h4>
            <select id="estado" name="estado">
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

        <!-- INPUT SELECT -->
        <h4>Bairro:</h4>
        <input type="text">
      </div>
    </div>

    <div class="sectionContato">
      <div class="dados-contato-titulo">
        <h3>Dados de Contato</h3>
      </div>
      <div class="dados-contato">
        <h4>Telefone:</h4>
        <input type="text">
        <h4>Whatsapp:</h4>
        <input type="text">
        <h4>Instagram:</h4>
        <input type="text">
        <h4>Facebook:</h4>
        <input type="text">
      </div>
    </div>

  </div>

  <div class="footer">
    <form method="post">
        <a href="../dashboard/"> <button class="botaoPe2" type="submit">Deslogar</button></a>
        <input class="botaoPe" type="submit" value="Adicionar Serviço">
        <input class="botaoPe" type="submit" value="Salvar">
    </form>
  </div>
</body>

</html>