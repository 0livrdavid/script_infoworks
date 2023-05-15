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
} else if ($acao ==  "SalvarImagemPerfil") {
    var_dump($_POST);
    var_dump($_FILES);
    var_dump($_FILES['imagem']);

    if(isset($_FILES['imagem'])) {
        move_uploaded_file($_FILES['imagem']['tmp_name'], '../../files/avatar'.$_FILES['imagem']['name']);
        
        

        $data = [
            'fk_idUsuario' => (int) $_POST['id'],
            'filepath' => '',
            'filename' => $_FILES['imagem']['name'],
            'filesize' => $_FILES['imagem']['size'],
            'filetype' => 1,
            'created_on' => 1,
            'status' => 1,
            'tipo' => 1,
        ];

        if ($_SESSION['usuario']['cpf'] == $_POST['cpf']) {
            $user = find_user($_POST['cpf']);
            if (is_array($user)) {
                //$iterate = bd_iterate_query_insert($data,'files', 'WHERE fk_idUsuario= "'.$_SESSION['usuario']['cpf'].'"');
        
                if ($iterate['flag']) {
                    //atualizarSessionUsuario($_SESSION['usuario']['cpf']);
                    //header("Refresh:0");
                    $response['flag'] = true;
                    $response['msg'] = "Imagem salva com sucesso!";
                } else {
                    $response['flag'] = false;
                    $response['msg'] = "Não foi possivel salvar imagem de perfil!";
                }
            } else {
                $response['flag'] = false;
                $response['msg'] = "Erro ao salvar a imagem!";
            }
        } else {
            $response['flag'] = false;
            $response['msg'] = "Você não tem autorização para editar esse perfil!";
        }
    } else {
        $response['flag'] = false;
        $response['msg'] = "Nenhuma imagem foi enviada!";
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
} else if ($acao ==  "CriarServico") {
    $data = [
        'cep' => $_POST['cep'],
    ];

    if ($_SESSION['usuario']['cpf'] == $_POST['cpf']) {
        $response['flag'] = true;
        $response['msg'] = "Serviço criado com sucesso!";
    } else {
        $response['flag'] = false;
        $response['msg'] = "Você não tem autorização para editar esse perfil!";
    }

    echo json_encode($response);
}