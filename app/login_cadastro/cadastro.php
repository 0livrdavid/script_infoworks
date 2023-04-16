<div class="logo-login-cadastro">
    <div class="logo-login-cadastro">
        <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo.png" alt="" srcset="">
    </div>
</div>
<div class="center">
    <h1>Não possui uma conta?</h1>
    <form method="post" action="" onsubmit="return validateFormCadastro(event);" novalidate>
        <p id="login_cadastro_msg" class="login_cadastro_msg"><?php echo $msg ?></p>
        <div class="txt_field">
          <input type="text" required name="nome" data-name="Nome completo">
          <span></span>
          <label>Nome completo</label>
        </div>
        <div class="txt_field">
          <input type="email" required name="email" data-name="Email">
          <span></span>
          <label>Email</label>
        </div>
        <div class="txt_field">
          <input type="text" required oninput="formatarCPF(this)" minlength="11" maxlength="14" name="cpf" data-name="CPF">
          <span></span>
          <label>CPF</label>
        </div>
        <div class="txt_field">
          <input type="password" required id="password" name="password" data-name="Senha">
          <span></span>
          <label>Senha</label>
        </div>
        <div class="txt_field">
          <input type="password" required id="confirm_password" name="confirm_password" data-name="Confirmar senha">
          <span></span>
          <label>Confirmar senha</label>
        </div>
        <div class="txt_field">
          <input type="text" required oninput="formatarData(this)" minlength="8" maxlength="10" name="data_nascimento" data-name="Data de Nascimento">
          <span></span>
          <label>Data de Nascimento</label>
        </div>
        <input name="tipo" type="submit" value="Cadastro">
        <div id="signup_link">
            <p>Voltar para o <a href="#" id="button_cadastrar" onclick="location.href='?page=login'">Login</a>.</p>
            <p><a href="../dashboard/">Voltar</a> à Página Inicial.</p>
        </div>
    </form>
</div>
