<?php
require_once '../../config.php';

$acao = $_POST['acao'];

if ($acao == "Cadastro") {
    $response['flag'] = false;
    $response['msg'] = "&#9940; Houve um erro ao cadastrar o usuário!";

    $data = [
        'nome' => $_POST['nome'],
        'data_nascimento' => $_POST['data_nascimento'],
        'email' => $_POST['email'],
        'cpf' => $_POST['cpf'],
        'password' => $_POST['password'],
        'confirm_password' => $_POST['confirm_password'],
    ];

    $user = find_user($data['cpf']);

    if (is_null($user)) {
        if ($data['nome'] != "" && $data['data_nascimento'] != "" &&
        $data['email'] != "" && $data['cpf'] != "" &&
        $data['password'] != "" && $data['confirm_password'] != "") {
            if ($data['password'] == $data['confirm_password']) {
                if (createUser($data)) {
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