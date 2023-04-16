<?php

var_dump($_POST);

$acao = (string) $_POST['acao'];


if ($acao == "Cadastro") {
    echo "aq2<br>";
    $user = [
        'nome' => (string) seguro(seguro_array($_POST)['nome']),
        'data_nascimento' => (string) seguro(seguro_array($_POST)['data_nascimento']),
        'email' => (string) seguro(seguro_array($_POST)['email']),
        'cpf' => (string) seguro(seguro_array($_POST)['cpf']),
        'password' => (string) seguro(seguro_array($_POST)['password']),
        'confirm_password' => (string) seguro(seguro_array($_POST)['confirm_password']),
    ];

    if (!is_array(find_user($user['cpf']))) {
        echo "aq3<br>";
        if ($user['nome'] != "" && $user['data_nascimento'] != "" &&
        $user['email'] != "" && $user['cpf'] != "" &&
        $user['password'] != "" && $user['confirm_password'] != "") {
            echo "aq4<br>";
            if ($user['password'] == $user['confirm_password']) {
                echo "aq5<br>";
//                    if (createUser($user)) {
//                        echo "aq6<br>";
//                        $_SESSION['login_cadastro_msg'] = "<span style='color: green;'>Cadastro de usuário com sucesso!</span>";
//                        header('Location: ../../app/login_cadastro/?page=cadastro');
//                    } else {
//                        $_SESSION['login_cadastro_msg'] = "<span style='color: red;'>	&#9888 Houve um erro ao cadastrar o usuário!</span>";
//                        header('Location: ../../app/login_cadastro/?page=cadastro');
//                    }
            } else {
                $_SESSION['login_cadastro_msg'] = "<span style='color: red;'>&warning Senha e confimação de senha diferentes!</span>";
                header('Location: ../../app/login_cadastro/?page=cadastro');
            }
        } else {
            $_SESSION['login_cadastro_msg'] = "<span style='color: red;'>&warning Preencha os campos obrigatórios!</span>";
            header('Location: ../../app/login_cadastro/?page=cadastro');
        }
    } else {
        $_SESSION['login_cadastro_msg'] = "<span style='color: red;'>&warning CPF já existe!</span>";
        header('Location: ../../app/login_cadastro/?page=cadastro');
    }
}