<?php



if (isset($_POST['tipo'])) {
    if ($acao == "Cadastro") {
        $user = [
            'nome' => (string) seguro(seguro_array($_POST)['nome']),
            'data_nascimento' => (string) seguro(seguro_array($_POST)['data_nascimento']),
            'celular' => (string) seguro(seguro_array($_POST)['celular']),
            'cpf' => (string) seguro(seguro_array($_POST)['cpf']),
            'password' => (string) seguro(seguro_array($_POST)['password']),
            'confirm_password' => (string) seguro(seguro_array($_POST)['confirm_password']),
        ];

        if (!is_array($find_user($user['cpf']))) {
            if (createUser($user)) {
                $_SESSION['login_cadastro_msg'] = "<span style='color: green;'>Cadastro de usuário com sucesso!</span>";
                header('Location: ../../app/login_cadastro/');
            } else {
                $_SESSION['login_cadastro_msg'] = "<span style='color: red;'>Houve um erro ao cadastrar o usuário!</span>";
                header('Location: ../../app/login_cadastro/');
            }
            
        } else {
            $_SESSION['login_cadastro_msg'] = "<span style='color: red;'>CPF já existe!</span>";
            header('Location: ../../app/login_cadastro/');
        }
    }
}