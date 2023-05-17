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
    $filename = uniqid();

    if(isset($_FILES['imagem_base'])) {    
        if ($_SESSION['usuario']['cpf'] == $_POST['cpf']) {
            $user = find_user($_POST['cpf']);
            if (is_array($user)) {
                $data = [
                    'status' => 0,
                ];

                $iterate = bd_iterate_query_update($data,'file', "WHERE fk_idUsuario = {$user['id']} AND status = 1");

                $path = '../../files/avatar/'.$_SESSION['usuario']['imagem_perfil'];
                unlink($path);

                $data = [
                    'fk_idUsuario' => (int) $user['id'],
                    'filepath' => 'avatar/'.$filename.'.jpg',
                    'filename' => $filename,
                    'filesize' => $_FILES['imagem']['size'],
                    'filetype' => $_FILES['imagem']['type'],
                    'created_on' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'tipo' => 1,
                ];

                $iterate = bd_iterate_query_insert($data,'file');
                move_uploaded_file($_FILES['imagem']['tmp_name'], '../../files/avatar/'.$filename.'.jpg');
                //move_uploaded_file($_FILES['imagem_base']['tmp_name'], '../../files/avatar/'.$_FILES['imagem_base']['name']);
        
                if ($iterate['flag']) {
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