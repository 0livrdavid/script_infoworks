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
    if ($_SESSION['usuario']['cpf'] == $_POST['servico_cpf']) {
        $user = find_user($_POST['servico_cpf']);
        if (is_array($user)) {
            abrir();

            $data = [
                'fk_idUsuario' => (int) $user['id'],
                'fk_idCategory' => $_POST['servico_categoria'],
                'valor' => $_POST['servico_preco'],
                'fk_idType' => $_POST['servico_tipo'],
                'descricao' => $_POST['servico_descricao'],
                'status' => 1,
            ];
        
            $iterate1 = bd_iterate_query_insert($data,'service');

            if(isset($_FILES['imagens'])) {
                $files = $_FILES['imagens'];
                $service_id = $iterate1['inserted_id'];
            
                foreach ($files['name'] as $key => $fileName) {
                    $fileName = uniqid();
                    $fileTmpName = $files['tmp_name'][$key];
                    $fileSize = $files['size'][$key];
                    $fileError = $files['error'][$key];
                    $fileType = $files['type'][$key];
            
                    if ($fileError === UPLOAD_ERR_OK) {
                        $data = [
                            'fk_idUsuario' => (int) $user['id'],
                            'filepath' => 'service/'.$fileName.'.jpg',
                            'filename' => $fileName,
                            'filesize' => $fileSize,
                            'filetype' => $fileType,
                            'created_on' => date('Y-m-d H:i:s'),
                            'status' => 1,
                            'tipo' => 2,
                        ];
                        
                        $iterate2 = bd_iterate_query_insert($data,'file');
                        move_uploaded_file($fileTmpName, '../../files/service/'.$fileName.'.jpg');

                        $data = [
                            'fk_idUsuario' => (int) $user['id'],
                            'fk_idService' => (int) $service_id,
                            'fk_idFile' => (int) $iterate2['inserted_id'],
                            'ordem' => $key,
                        ];

                        $iterate3 = bd_iterate_query_insert($data,'service_file');

                        $flags = [$iterate1['flag'], $iterate2['flag'], $iterate3['flag']];

                        if ($iterate1['flag'] && $iterate2['flag'] && $iterate3['flag']) {
                            commit();
                            $response['flag'] = true;
                            $response['msg'] = "Serviço salvo com sucesso!";
                        } else {
                            rollback();
                            $response['flag'] = false;
                            $response['msg'] = "Não foi possivel salvar serviço!";
                        }
                    } else {
                        rollback();
                        $response['flag'] = false;
                        $response['msg'] = "Não foi possivel salvar serviço: $fileName - $fileError";
                    }
                }
            } else {
                rollback();
                $response['flag'] = false;
                $response['msg'] = "Adicione imagens para salvar o serviço!";
            }
        } else {
            $response['flag'] = false;
            $response['msg'] = "Erro ao salvar a serviço!";
        }
    } else {
        $response['flag'] = false;
        $response['msg'] = "Você não tem autorização para editar nesse perfil!";
    }

    echo json_encode($response);
} else if ($acao ==  "GetServico") {
    $service = getService($_POST['id'])[0];
    if (is_array($service)) {
        $response['service'] = $service;
        $response['imagens'] = getFilesService($response['service']['id']);
        foreach ($response['imagens'] as $key => $value) {
            $imagens[$key]['filename'] = $value['filename'];
            $imagens[$key]['filepath'] = URL_BASE_FILES.$value['filepath'];
        }
        $response['imagens'] = $imagens;
        $response['flag'] = true;
        $response['msg'] = "Serviço achado com sucesso!";
    } else {
        $response['flag'] = false;
        $response['msg'] = "Erro ao procurar serviço!";
    }

    echo json_encode($response);
}