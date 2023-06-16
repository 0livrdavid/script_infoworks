<?php
require_once '../../config.php';

$acao = $_POST['acao'];

if ($acao ==  "CriarServico") {
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

               $iterate1 = bd_iterate_query_insert($data, 'service');

               if (isset($_FILES['imagens'])) {
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
                                   'filepath' => 'service/' . $fileName . '.jpg',
                                   'filename' => $fileName,
                                   'filesize' => $fileSize,
                                   'filetype' => $fileType,
                                   'created_on' => date('Y-m-d H:i:s'),
                                   'status' => 1,
                                   'tipo' => 2,
                              ];

                              $iterate2 = bd_iterate_query_insert($data, 'file');
                              move_uploaded_file($fileTmpName, '../../files/service/' . $fileName . '.jpg');

                              $data = [
                                   'fk_idUsuario' => (int) $user['id'],
                                   'fk_idService' => (int) $service_id,
                                   'fk_idFile' => (int) $iterate2['inserted_id'],
                                   'ordem' => $key,
                              ];

                              $iterate3 = bd_iterate_query_insert($data, 'service_file');

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
} else if ($acao ==  "EditarServico") {
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

               $iterate1 = bd_iterate_query_update($data, 'service');

               if (isset($_FILES['imagens'])) {
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
                                   'filepath' => 'service/' . $fileName . '.jpg',
                                   'filename' => $fileName,
                                   'filesize' => $fileSize,
                                   'filetype' => $fileType,
                                   'created_on' => date('Y-m-d H:i:s'),
                                   'status' => 1,
                                   'tipo' => 2,
                              ];

                              $iterate2 = bd_iterate_query_insert($data, 'file');
                              move_uploaded_file($fileTmpName, '../../files/service/' . $fileName . '.jpg');

                              $data = [
                                   'fk_idUsuario' => (int) $user['id'],
                                   'fk_idService' => (int) $service_id,
                                   'fk_idFile' => (int) $iterate2['inserted_id'],
                                   'ordem' => $key,
                              ];

                              $iterate3 = bd_iterate_query_insert($data, 'service_file');

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
               $imagens[$key]['filepath'] = URL_BASE_FILES . $value['filepath'];
          }
          $response['imagens'] = $imagens;
          $response['flag'] = true;
          $response['msg'] = "Serviço achado com sucesso!";
     } else {
          $response['flag'] = false;
          $response['msg'] = "Erro ao procurar serviço!";
     }

     echo json_encode($response);
} else if ($acao ==  "DeletarServico") {
     $service = getService($_POST['id'])[0];

     if (is_array($service)) {
          $response['service'] = $service;
          $response['imagens'] = getFilesService($response['service']['id']);
          foreach ($response['imagens'] as $key => $value) {
               $imagens[$key]['filename'] = $value['filename'];
               $imagens[$key]['filepath'] = URL_BASE_FILES . $value['filepath'];
          }
          $response['imagens'] = $imagens;
          $response['flag'] = true;
          $response['msg'] = "Serviço deletado com sucesso!";
     } else {
          $response['flag'] = false;
          $response['msg'] = "Erro ao procurar serviço!";
     }

     echo json_encode($response);
} else if ($acao == "AdicionaComentarioServico") {
     
     $service = getService($_POST['id'])[0];

     if (is_array($service)) {
          abrir();

          $data = [
               'fk_idUsuario' => $_POST['usuario'],
               'fk_idService' => $_POST['id'],
               'comentario' => $_POST['comentario'],
               'status' => 1,
               'created_at' => date('Y-m-d H:i:'),
          ];
          $iterate1 = bd_iterate_query_insert($data, 'service_comment');

          $data = [
               'fk_idUsuario' => $_POST['usuario'],
               'fk_idService' => $_POST['id'],
               'nota' => $_POST['nota'],
               'status' => 1,
               'created_at' => date('Y-m-d H:i:'),
          ];
          $iterate2 = bd_iterate_query_insert($data, 'service_evaluation');

          $flags = [$iterate1['flag'], $iterate2['flag']];

          if ($iterate1['flag'] && $iterate2['flag']) {
               commit();
               $response['flag'] = true;
               $response['msg'] = "Adicionado avaliação com sucesso!";
          } else {
               rollback();
               $response['flag'] = false;
               $response['msg'] = "Erro ao adicionar avaliação serviço!";
          }
     } else {
          $response['flag'] = false;
          $response['msg'] = "Erro ao adicionar avaliação serviço!";
     }

     echo json_encode($response);
}
