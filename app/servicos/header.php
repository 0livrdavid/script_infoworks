<div class="header">
    <div class="header-logo">
        <div class="logo-dashboard">
            <a href="../dashboard/index.php">
                <div class="img_logo_dashboard">
                    <img src="<?php echo URL_BASE_ASSETS_IMG; ?>InfoWorks_logo.png" alt="logo">
                </div>
            </a>
        </div>
    </div>
    <div class="header-menu-logout">
        <a class="btn btn-primary botao-login" href="../login_cadastro/">Entrar</a>
    </div>
    <div class="header-menu-logged">
        
        <p style="color: #fff; margin-bottom: 0; font-size: 1rem"><?php echo resume_nome($_SESSION['usuario_nome']) ?></p>
        <div class="perfil">
            <a class="botao-circular" href="../perfil/">
                <img style="object-fit: cover;" src="../../files/avatar/<?php echo (isset($_SESSION['usuario']['imagem_perfil'])) ? $_SESSION['usuario']['imagem_perfil'] : 'avatar.png'; ?>" alt="Perfil">
            </a>
        </div>
    </div>
</div>