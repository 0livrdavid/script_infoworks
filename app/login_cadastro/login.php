<div class="logo-login-cadastro">
    <div class="logo-login-cadastro">
        <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo.png" alt="" srcset="">
    </div>
</div>
<div class="center">
    <h1>Entrar</h1>
    <form method="post" action="../../ajax/login_cadastro.php">
        <p id="msg_login"></p>
        <input name="tipo" type="hidden" value="login">
        <div class="txt_field">
            <input name="cpf" type="text" oninput="formatarCPF(this)" minlength="11" maxlength="14">
            <span></span>
            <label>CPF</label>
        </div>
        <div class="txt_field">
            <input name="password" type="password">
            <span></span>
            <label>Senha</label>
        </div>
        <div class="pass" onclick="switchLogin('esqueceu-senha')">Esqueceu sua senha?</div>
        <input type="submit" value="Entrar">
        <div id="signup_link">
            <p>Ainda não possui uma conta? <a href="#" id="button_cadastrar" onclick="switchLogin('cadastrar')">Cadastrar</a>.</p>
            <p><a href="../dashboard/">Voltar</a> à Página Inicial.</p>
        </div>
    </form>
</div>

