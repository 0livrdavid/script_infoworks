<?php
require_once '../../config.php';

$_SESSION[''] = "";

if (isset($_POST['login'])) {
    $array = seguro_array($_POST);

    session_cache_expire(525600);
    $_SESSION['session_id']=session_id();
    session_start();

    if (is_array($user = find_user($array['cpf'], $array['password']))) {
        session_regenerate_id(true);
        $_SESSION['usuario'] = (array) $user;
        $_SESSION['usuario']['nome'] = (string) html_entity_decode($_SESSION['usuario']['nome']);
        $_SESSION['userid'] = (int) $_SESSION['usuario']['id'];
        $_SESSION['SessaoLogin']=md5("seg".$_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"]);

        bd_query("INSERT INTO cvslogins(user_id) VALUES(".$_SESSION["userid"].")", $conexao, 0);

        if ($_SESSION['usuario']['ativo'] == 1) {
            if ($_SESSION['usuario']['regra_id'] == 10) {
                header('Location: ../../app/admin/dashboard/admin');
            } else if ($_SESSION['usuario']['regra_id'] == 1 || $_SESSION['usuario']['regra_id'] == 2) {
                if($_SESSION['usuario']['primeiro_acesso'] == 0){
                    $_SESSION['home'] = '/app/acesso/wizard/index';
                    header('Location: wizard/index');
                }else{
                    $_SESSION['home'] = '/app/dashboard';
                    header('Location: ../dashboard');
                }
            }
        } else {
            $msg='<font color=\'red\'>'.lang('ativar_usuario_mensagem7', 1)."</font>";
        }
    } else {
        $msg = $user;
    }
}