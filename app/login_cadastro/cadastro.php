<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>InfoWorks - Cadastre-se na plataforma</title>
    <link rel="stylesheet" href="styles/loginStyle.css">
    <script src="scripts/cadastroScript.js"></script>
    <link rel="icon" type="image/x-icon" href="pictures/InfoWorks_logo_fundo.ico">
  </head>
  <body>
    <div class="logo">
      <div class="img_logo">
         <img src="../../src/pictures/InfoWorks_logo.png" alt="" srcset="">
      </div>
    </div>
    <div class="center">
      <h1>Cadastrar</h1>
      <form method="post">
        <div class="txt_field">
          <input type="text" required>
          <span></span>
          <label>Nome completo</label>
        </div>
        <div class="txt_field">
          <input type="text" required oninput="formatarData(this)" minlength="8" maxlength="10">
          <span></span>
          <label>Data de Nascimento</label>
        </div>
        <div class="txt_field">
          <input type="text" required oninput="formatarCEL(this)" minlength="11" maxlength="14">
          <span></span>
          <label>Celular</label>
        </div>
        <div class="txt_field">
          <input type="text" required oninput="formatarCPF(this)" minlength="11" maxlength="14">
          <span></span>
          <label>CPF</label>
        </div>
        <div class="txt_field">
          <input type="password" required>
          <span></span>
          <label>Senha</label>
        </div>
        <div class="txt_field">
          <input type="password" required>
          <span></span>
          <label>Confirmar senha</label>
        </div>
        <input type="submit" value="Cadastrar">
        <div class="signup_link">
          Já possui uma conta? <a href="login.html">Entrar</a>.
          <p><a href="index.html">Voltar</a> à Página Inicial.</p>
        </div>
      </form>
    </div>
  </body>
</html>
