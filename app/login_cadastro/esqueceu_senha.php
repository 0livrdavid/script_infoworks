<div class="logo-login-cadastro">
    <div class="logo-login-cadastro">
        <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo.png" alt="" srcset="">
    </div>
</div>
<div class="center">
    <h1>Esqueceu a senha?</h1>
    <form method="post" action="../../ajax/login_cadastro.php">
        <p id="msg_login" class="msg_login"><?php echo $msg ?></p>
        <input name="tipo" type="hidden" value="esqueceu_senha">
        <div class="txt_field">
            <input name="cpf" type="text" oninput="formatarCPF(this)" minlength="11" maxlength="14">
            <span></span>
            <label>CPF</label>
        </div>
        <input name="tipo" type="submit" value="esqueceu_senha">
        <div id="signup_link">
            <p>Voltar para o <a href="#" id="button_cadastrar" onclick="switchLogin('login')">Login</a>.</p>
            <p><a href="../dashboard/">Voltar</a> à Página Inicial.</p>
        </div>
    </form>
</div>