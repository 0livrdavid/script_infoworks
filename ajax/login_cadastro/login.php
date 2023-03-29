<?php
$page = (string) $_POST['page'];
$msg = (string) $_SESSION['login_msg'];

$acao = (string) seguro(seguro_array($_POST)['tipo']);
$cpf = (string) seguro(seguro_array($_POST)['cpf']);
$password = (string) seguro(seguro_array($_POST)['password']);

if (isset($_POST['tipo'])) {
    if ($acao == "login") {
        session_cache_expire(525600);
        $_SESSION['session_id']=session_id();
        session_start();
    
        $user = find_user($cpf);

        if (is_array($user['user'])) {
            $user = $user['user'];
            $flag_password = findMatchPassword($password, $user['salt'], $user['status']);

            if ($flag_password['flag'] == true) {
                session_regenerate_id(true);
                $_SESSION['usuario'] = (array) $user;
                $_SESSION['usuario']['nome'] = (string) html_entity_decode($_SESSION['usuario']['nome']);
                $_SESSION['idUsuario'] = (int) $_SESSION['usuario']['id'];
                $_SESSION['SessaoLogin']=md5("seg".$_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"]);
        
                header('Location: ../../app/dashboard/');
            } else {
                $_SESSION['login_msg'] = $flag_password['msg'];
                header('Location: ../../app/login_cadastro/');
            }
        } else {
            $_SESSION['login_msg'] = $user['msg'];
            header('Location: ../../app/login_cadastro/');
        }
    }
}