<?php
require_once '../../config.php';

$acao = (string) $_POST['acao'];

if ($acao == "Cadastro") {
    $response['flag'] = false;
    $response['msg'] = "&#9940; Houve um erro ao cadastrar o usuário!";

    $user = [
        'nome' => (string) seguro(seguro_array($_POST)['nome']),
        'data_nascimento' => (string) seguro(seguro_array($_POST)['data_nascimento']),
        'email' => (string) seguro(seguro_array($_POST)['email']),
        'cpf' => (string) seguro(seguro_array($_POST)['cpf']),
        'password' => (string) seguro(seguro_array($_POST)['password']),
        'confirm_password' => (string) seguro(seguro_array($_POST)['confirm_password']),
    ];

    if (!is_array(find_user($user['cpf']))) {
        if ($user['nome'] != "" && $user['data_nascimento'] != "" &&
        $user['email'] != "" && $user['cpf'] != "" &&
        $user['password'] != "" && $user['confirm_password'] != "") {
            if ($user['password'] == $user['confirm_password']) {
                if (createUser($user)) {
                    $response['flag'] = true;
                    $response['msg'] = "Cadastro de usuário com sucesso!";
                } else {
                    $response['flag'] = false;
                    $response['msg'] = "&#9940; Houve um erro ao cadastrar o usuário!";
                }
            } else {
                $response['flag'] = false;
                $response['msg'] = "&#9888; Senha e confimação de senha diferentes!";
            }
        } else {
            $response['flag'] = false;
            $response['msg'] = "&#9888; Preencha os campos obrigatórios!";
        }
    } else {
        $response['flag'] = false;
        $response['msg'] = "&#9888; CPF já existe!";
    }

    echo json_encode($response);
}