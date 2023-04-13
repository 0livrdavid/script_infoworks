<div class="logo-login-cadastro">
    <div class="logo-login-cadastro">
        <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo.png" alt="" srcset="">
    </div>
</div>
<div class="center">
    <h1>Não possui uma conta?</h1>
    <form method="post" action="">
        <p id="msg_login" class="msg_login"><?php echo $msg ?></p>
        <div class="txt_field">
          <input type="text" required name="nome">
          <span></span>
          <label>Nome completo</label>
        </div>
        <div class="txt_field">
          <input type="text" required oninput="formatarData(this)" minlength="8" maxlength="10" name="data_nascimento">
          <span></span>
          <label>Data de Nascimento</label>
        </div>
        <div class="txt_field">
          <input type="text" required oninput="formatarCEL(this)" minlength="11" maxlength="14" name="celular">
          <span></span>
          <label>Celular</label>
        </div>
        <div class="txt_field">
          <input type="text" required oninput="formatarCPF(this)" minlength="11" maxlength="14" name="cpf">
          <span></span>
          <label>CPF</label>
        </div>
        <div class="txt_field">
          <input type="password" required name="password">
          <span></span>
          <label>Senha</label>
        </div>
        <div class="txt_field">
          <input type="password" required name="confirm_password">
          <span></span>
          <label>Confirmar senha</label>
        </div>
        <input name="tipo" type="submit" value="Cadastrar">
        <div id="signup_link">
            <p>Voltar para o <a href="#" id="button_cadastrar" onclick="location.href='?page=login'">Login</a>.</p>
            <p><a href="../dashboard/">Voltar</a> à Página Inicial.</p>
        </div>
    </form>
</div>
