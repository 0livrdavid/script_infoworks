<?php
require_once '../../config.php';

$acao = $_POST['acao'];

if ($acao == "SalvarPerfil") {
    $data = [
        'cep' => $_POST['cep'],
        'fk_cidade' => $_POST['cidade'],
        'fk_estado' => $_POST['estado'],
        'rua' => $_POST['rua'],
        'numero' => $_POST['numero'],
        'bairro' => $_POST['bairro'],
        'sobre_mim' => $_POST['sobre_mim'],
        'formacao' => $_POST['formacao'],
        'telefone' => $_POST['telefone'],
        'whatsapp' => $_POST['whatsapp'],
        'instagram' => $_POST['instagram'],
        'facebook' => $_POST['facebook'],
    ];

    $data = array_diff_assoc($data, $_SESSION['usuario']);

    if ($_SESSION['usuario']['cpf'] == $_POST['cpf']) {
        $user = find_user($_POST['cpf']);

        if (is_array($user)) {
            $iterate = bd_iterate_query_update($data,'user', 'WHERE cpf= "'.$_SESSION['usuario']['cpf'].'"');
    
            if ($iterate['flag']) {
                atualizarSessionUsuario($_SESSION['usuario']['cpf']);
                $response['flag'] = true;
                $response['msg'] = "Perfil salvo com sucesso!";
            } else {
                $response['flag'] = false;
                $response['msg'] = "Não foi possivel salvar os dados de perfil!";
            }
        } else {
            $response['flag'] = false;
            $response['msg'] = "Não foi possivel salvar os dados de perfil!";
        }
    } else {
        $response['flag'] = false;
        $response['msg'] = "Você não tem autorização para editar esse perfil!";
    }

    echo json_encode($response);
} else if ($acao ==  "DeslogarUsuario") {
    session_destroy();
    
    if (!(session_status() == PHP_SESSION_ACTIVE)) {
        $response['flag'] = true;
        $response['msg'] = "Usuário deslogado com sucesso!";
    } else {
        $response['flag'] = false;
        $response['msg'] = "Não foi possível deslogar o usuário!";
    }
    
    echo json_encode($response);
}