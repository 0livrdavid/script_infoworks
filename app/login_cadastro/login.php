<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>InfoWorks - Entre na plataforma</title>
    <link rel="stylesheet" href="styles/loginStyle.css">
    <script src="scripts/cadastroScript.js"></script>
    <link rel="icon" type="image/x-icon" href="pictures/InfoWorks_logo_fundo.ico">
  </head>
  <body>

    <div class="logo">
      <div class="img_logo">
         <img src="pictures/InfoWorks_logo.png" alt="" srcset="">
      </div>
    </div>

    <div class="center">
      <h1>Entrar</h1>
      <form method="post">
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
        <div class="pass">Esqueceu sua senha?</div>
        <input type="submit" value="Entrar">
        <div class="signup_link">
          Ainda não possui uma conta? <a href="cadastro.html">Cadastrar</a>.
          <p><a href="index.html">Voltar</a> à Página Inicial.</p>
        </div>
      </form>
    </div>
    
  </body>
</html>
