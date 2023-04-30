<div class="header">
    <div class="header-logo">
        <div class="logo-dashboard">
            <div class="img_logo_dashboard">
                <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>InfoWorks_logo.png" alt="logo">
            </div>
        </div>
    </div>
    <div class="header-menu-logout">
        <a class="btn btn-primary botao-login" href="../login_cadastro/">Entrar</a>
    </div>
    <div class="header-menu-logged">
        <div class="notificao">
            <button class="botao-noti">
                <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>notification.png" alt="Notificações">
            </button>
        </div>
        <p style="color: #fff"><?php echo $_SESSION['usuario']['nome'] ?></p>
        <div class="perfil">
            <a class="botao-circular" href="../perfil/">
                <img src="<?php echo URL_BASE_ASSETS_PICTURES; ?>pessoa.jfif" alt="Perfil">
            </a>
        </div>
    </div>
</div>