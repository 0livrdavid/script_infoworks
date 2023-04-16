<?php

$acao = (string) $_POST['tipo'];

if (isset($_POST['tipo'])) {
    if ($acao == "Login") {
        $cpf = (string) seguro(seguro_array($_POST)['cpf']);
        $password = (string) seguro(seguro_array($_POST)['password']);

        session_cache_expire(525600);
        $_SESSION['session_id']=session_id();
        session_start();
    
        $user = find_user($cpf);

        if (is_array($user)) {
            $flag_password = findMatchPassword($password, $user['salt'], $user['status']);

            if ($flag_password['flag'] == true) {
                session_regenerate_id(true);
                $_SESSION['usuario'] = (array) $user;
                $_SESSION['usuario']['nome'] = (string) html_entity_decode($_SESSION['usuario']['nome']);
                $_SESSION['idUsuario'] = (int) $_SESSION['usuario']['id'];
                $_SESSION['SessaoLogin']=md5("seg".$_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"]);
        
                header('Location: ../../app/dashboard/');
            } else {
                $_SESSION['login_cadastro_msg'] = $flag_password['msg'];
                header('Location: ../../app/login_cadastro/');
            }
        } else {
            $_SESSION['login_cadastro_msg'] = "<span style='color: red;'>CPF ou Senha incorreto!</span>";
            header('Location: ../../app/login_cadastro/');
        }
    }
}