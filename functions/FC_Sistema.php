<?php

/* * ***************************************************

  Interação

 * ************************************************** */

function insere_interacao($usuario_id, $origem_id, $origem, $alvo_id)
{
    $query = "INSERT INTO cvsinteracao
(usuario_id, origem_id, origem, criado_em, flag, alvo_id) 
VALUES 
(" . $usuario_id . "," . $origem_id . "," . $origem . ",'".dataHoraAtual()."',0," . $alvo_id . ")";

    return bd_query($query, $_SESSION['conexao'], 0);
}

function busca_nro_notificacao($where)
{
    $query = "SELECT count(id) as count FROM cvsinteracao " . $where;
    $dado = bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));

    return $dado['count'];
}

function busca_notificacoes($where)
{
    $query = "SELECT id, usuario_id, origem_id, origem, criado_em, flag, alvo_id FROM cvsinteracao $where";

    return bd_query($query, $_SESSION['conexao'], 0);
}

function set_valores_noticacao($usuario_id)
{
    $query = "UPDATE cvsinteracao SET flag=1 WHERE alvo_id=" . $usuario_id . " and (origem=0 or origem=1 or origem=2 or origem=3 or origem=4 or origem=5 or origem=6 or origem=7 or origem=8)";

    return bd_query($query, $_SESSION['conexao'], 0);
}

/* * ***************************************************

  Atividades

 * ************************************************** */

function busca_atividades_tipo()
{
    $query = "SELECT * FROM cvsatividades_tipo WHERE status = 1 ORDER BY nome";

    return bd_query($query, $_SESSION['conexao'], 0);
}

function busca_all_atividades_tipo()
{
    $query = "SELECT * FROM cvsatividades_tipo ORDER BY nome";

    return bd_query($query, $_SESSION['conexao'], 0);
}

function busca_tipo_atividade_id($id)
{
    $query = "SELECT * FROM cvsatividades_tipo WHERE id=" . (int)$id;

    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function editar_atividade_tipo($nome,$nome_eng,$nome_esp,$switch_check, $id)
{
    if ($nome != '') {
        $query = 'UPDATE cvsatividades_tipo SET nome=\''.$nome.'\',nome_eng=\''.$nome_eng.'\',nome_esp=\''.$nome_esp.'\',ativar_link=\''.$switch_check.'\' WHERE id='.(int)$id;
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        if ($resultado) {
            return lang('funcoes_editado_sucesso',1);
        } else {
            return lang('funcoes_erro_editar_informacao_aguarde',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function salva_atividade($nome, $nome_eng, $nome_esp){
    if ($nome != '') {
        $query = 'INSERT INTO cvsatividades_tipo(nome,nome_eng,nome_esp, status) VALUES ( "'.$nome.'", "'.$nome_eng.'", "'.$nome_esp.'",1)';
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        if ($resultado) {
            return lang('funcoes_cadastro_realizado_sucesso',1);
        } else {
            return lang('funcoes_erro_inserir_informacao_aguarde',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function proxima_atividade($mentor_id, $solicitante_id,$mentoria_id,$mentoriaTipo){
    if($mentoriaTipo==0){
        $query = "SELECT id, inicio FROM cvsatividades WHERE status=1 AND mentoria_id=$mentoria_id and 
   ((solicitante_id=$mentor_id AND solicitado_id=$solicitante_id) OR 
   (solicitante_id=$solicitante_id AND solicitado_id=$mentor_id)) 
   AND realizada = 0 AND (fim > '".dataHoraAtual()."') ORDER BY inicio LIMIT 0,1";
    }else{

        $query = "SELECT id, inicio FROM cvsatividades WHERE status=1 AND mentoria_id=$mentoria_id and 
   ((solicitante_id=$mentor_id AND solicitado_id=0)) AND realizada = 0 AND (fim > '".dataHoraAtual()."') AND atividade_tipo=1 ORDER BY inicio LIMIT 0,1";

    }


    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

/* * **************************

  Usuarios

 * *************************** */

function busca_avatar_usuario($user_id)
{
    $query = 'SELECT pathnamehash FROM cvs_files WHERE filetype = 1 and userid =' . $user_id;
    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function busca_nome_user($user_id)
{
    $query = "SELECT u.nome as nome
      FROM cvsusuario_usuarios as u 
    where u.id=" . $user_id;
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    $user = bd_fetch_array($dados);

    return $user['nome'];
}

function busca_usuario($user_id)
{
    $query = "SELECT nome, email,idioma, regra_id FROM cvsusuario_usuarios where id = $user_id";

    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function busca_emails_mentorados_mentores( $data, $limite, $user_id)
{
    $query = "SELECT u.id as id, u.nome as nome,u.regra_id as regra_id FROM cvsusuario_usuarios as u 
               
                WHERE  u.status=1 AND (u.id<>".$user_id.") AND (u.nome like '%". $data ."%' OR u.email like  '%". $data ."%') 
                ORDER BY u.nome $limite";

    $dados = bd_query($query, $_SESSION['conexao'], 0);

    $array = array();

    while ($dado = bd_fetch_array($dados)) {
        $array[] = $dado;
    }

    return $array;
}

function busca_emails_mentorados_mentores_admin( $data, $limite, $user_id)
{
    $query = "SELECT u.id as id, u.nome as nome,u.regra_id as regra_id FROM cvsusuario_usuarios as u
                WHERE  u.status=1 AND (u.id<>".$user_id.") AND (u.nome like '%". $data ."%' OR u.email like  '%". $data ."%') 
                ORDER BY u.nome $limite";

    $dados = bd_query($query, $_SESSION['conexao'], 0);

    $array = array();

    while ($dado = bd_fetch_array($dados)) {
        $array[] = $dado;
    }

    return $array;
}

function busca_pessoas_sem_tipo($data, $limite, $user_id)
{
    $query = 'SELECT u.id as id, u.nome as nome,u.regra_id as regra_id, a.cidade as cidade FROM cvsusuario_usuarios as u
  join cvsusuario_endereco as a on u.id=a.usuario_id
  WHERE  u.status<>0 and u.id<>' . $user_id . ' and u.ativo=1 and u.nome like \'%' . $data . '%\' and (u.regra_id=1 or u.regra_id=2 or u.regra_id=3) order by u.nome ' . $limite;

    $dados = bd_query($query, $_SESSION['conexao'], 0);

    $array = array();

    while ($dado = bd_fetch_array($dados)) {
        $array[] = $dado;
    }

    return $array;
}

function busca_user($user_id){

    $query = "SELECT * FROM cvsusuario_usuarios as u
        where u.id=" . $user_id;

    $dados = bd_query($query, $_SESSION['conexao'], 0);
    if($dados){
        return bd_fetch_array($dados);
    }else{
        return null;
    }
}

function busca_user_pilares( $user_id,$tipo=0)
{
    $areas=array();
    $query = "SELECT cp.nome as pilar,cp.nome_eng as pilar_eng,cp.nome_esp as pilar_esp, cp.cor as cor, 
    cp.descricao,cp.descricao_eng,cp.descricao_esp, p.pilar_id 
    FROM cvsusuario_pilares as p JOIN cvspilares as cp ON p.pilar_id=cp.id WHERE p.status=0 and usuario_id=" . $user_id;
    $dados = bd_query($query, $_SESSION['conexao'], 0);

    while ($dado = bd_fetch_assoc($dados)) {
        $areas[] = $dado;
    }

    return $areas;
}

function busca_user_pilares_sol( $user_id)
{
    $areas=array();
    $query = "SELECT cp.nome as pilar,cp.nome_eng as pilar_eng,cp.nome_esp as pilar_esp, cp.cor as cor, p.pilar_id,
     cp.descricao,cp.descricao_eng,cp.descricao_esp
    FROM cvsusuario_pilares_sol as p 
    JOIN cvspilares as cp ON p.pilar_id=cp.id WHERE p.status=0 and usuario_id=" . $user_id;
    $dados = bd_query($query, $_SESSION['conexao'], 0);

    while ($dado = bd_fetch_assoc($dados)) {
        $areas[] = $dado;
    }

    return $areas;
}
/* * ****************************
  Senha
 */

function altera_senha($id){
    $senha =  rand(10000,99999);

    $salt = base64_encode(rand_bytes(8, true));

    $password = encrypt_password($senha, $salt);

    $query = "UPDATE cvsusuario_usuarios SET  
                salt = '$salt',
                password = '$password',
                primeira_senha='$senha'
              WHERE id =".(int)$id;

    $resultado = bd_query($query, $_SESSION['conexao'], 0);
    if($resultado){
        $resultado = $senha;
    }

    return $resultado;
}

/* * ****************************

  Emails Padrao

 */

/* * ****************************

  Emails

 */
function busca_emails($where)
{
    $query = 'SELECT e.ped as ped, u.nome as nome,  eu.id as email_user_id, eu.resp_id as resp_id, eu.sent_id as sent_id, eu.email_id as email_id, eu.receveid_id as receveid_id, eu.flag as flag, eu.type as type, eu.cc as cc, e.origem_id as origem_id, e.time as time, e.subject as subject
                FROM cvsemail_users as eu 
                join cvsemail as e on eu.email_id=e.id 
                left join cvsusuario_usuarios as u on eu.sent_id=u.id ' . $where;

    add_logs("email_mensagens", $query);
    return bd_query($query, $_SESSION['conexao'], 0);
}

function busca_emails_total($where)
{
    $query = 'SELECT count(eu.id) as count
                FROM cvsemail_users as eu 
                join cvsemail as e on eu.email_id=e.id ' . $where;
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    $dados = bd_fetch_array($dados);
    return $dados['count'];
}

function email_enviados($email_id)
{
    $query = 'SELECT id, resp_id, sent_id, email_id, receveid_id, flag, type, cc FROM cvsemail_users WHERE type<>0 and email_id=' . $email_id;
    return bd_query($query, $_SESSION['conexao'], 0);
}

function monta_notificao_emails( $emails)
{
    $html = '';
    $max = 8;
    $count = 0;
    $qtd = 0;
    while ($email = bd_fetch_array($emails)) {
        $nome = html_entity_decode(busca_nome_user($email['sent_id']));
        if ($email['type'] == 1) {
            $html = $html . '<li>
                                <div class="alert-mensagens">
                                       <a href="javascript:;" onclick="$.redirect(\''.URL_BASE_APP.'inbox/mensagem\', {mensagem: '. $email['email_user_id'] .'}, \'POST\');">'. lang('funcoes_voce_mensagem_de',1) ." ". substr($nome, 0, 15) . '</a>             
                                </div>
                             </li>
                             <li class="divider"></li>';
            $qtd++;
        } elseif ($email['type'] == 4) {
            $html = $html . '<li>
                                 <div class="alert-mensagens">      
                                       <a href="'.URL_BASE_APP.'solicitacao?id='. $email['origem_id'] .'" >' . lang('funcoes_voce_solicitacao_de',1) ." ". substr($nome, 0, 15) . '</a>             
                                  </div>
                             </li>
             <li class="divider">
             </li>';
            $qtd++;
        }
    }
    if ($qtd > 0) {
        $html = $html . ' <li><div class="alert-veja-mais"><a href="'.URL_BASE_APP.'inbox/inbox.php">'. lang('funcoes_veja_mais',1) .'</a></div></li>';
    }

    if ($qtd == 0) {
        $html = $html . ' <li style="text-align: center;">'. lang('funcoes_voce_nao_mensagem',1) .'</li>';
        $html = $html . ' <li><div class="alert-veja-mais"><a href="'.URL_BASE_APP.'inbox/inbox.php">'. lang('funcoes_veja_mais',1) .'</a></div></li>';
    }

    return $html;
}

function busca_email($email, $user_id)
{
    $query = 'SELECT e.ped as ped, u.nome as nome,eu.id as email_user_id, eu.resp_id as resp_id, eu.sent_id as sent_id, eu.email_id as email_id, eu.receveid_id as receveid_id, eu.flag as flag, eu.type as user_type, eu.cc as cc, e.type, e.time as time, e.message as message, e.subject as subject, e.origem_id as origem_id
                FROM cvsemail_users as eu 
                join cvsemail as e on eu.email_id=e.id 
                left join cvsusuario_usuarios as u on eu.sent_id=u.id
                where eu.id=' . $email . ' and eu.receveid_id=' . $user_id . ' and eu.sent_id!=' . $user_id;
    add_logs("email", $query);
    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function busca_email_permissao($email, $user_id)
{
    $query = 'SELECT e.ped as ped, u.nome as nome,eu.id as email_user_id, eu.resp_id as resp_id, eu.sent_id as sent_id, eu.email_id as email_id, eu.receveid_id as receveid_id, eu.flag as flag, eu.type as user_type, eu.cc as cc, e.type, e.time as time, e.message as message, e.subject as subject, e.origem_id as origem_id
                FROM cvsemail_users as eu 
                join cvsemail as e on eu.email_id=e.id 
                left join cvsusuario_usuarios as u on eu.sent_id=u.id
                where eu.id=' . $email . ' and (eu.receveid_id=' . $user_id . ' or eu.sent_id=' . $user_id.") ORDER BY time desc";
    add_logs("email", $query);
    return (bd_query($query, $_SESSION['conexao'], 0));
}

function busca_email_enviado($email, $user_id)
{
    $query = 'SELECT e.ped as ped, u.nome as nome,eu.id as email_user_id, eu.resp_id as resp_id, eu.sent_id as sent_id, eu.email_id as email_id, eu.receveid_id as receveid_id, eu.flag as flag, eu.type as user_type, eu.cc as cc, e.type, e.time as time, e.message as message, e.subject as subject, e.origem_id as origem_id
                FROM cvsemail_users as eu 
                join cvsemail as e on eu.email_id=e.id 
                left join cvsusuario_usuarios as u on eu.sent_id=u.id
                where eu.id=' . $email . "  and eu.sent_id=" . $user_id;
    add_logs("email_enviado", $query);
    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function set_flag_mensagem($mensagem_id)
{
    $query = 'UPDATE cvsemail_users SET flag=1 WHERE id=' . $mensagem_id;
    $resultado = bd_query($query, $_SESSION['conexao'], 0);
}

function busca_solicitacao_mentoria($origem_id)
{
    $query = "SELECT * FROM cvsmentoria WHERE id=" . $origem_id;
    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function gera_thumb($in, $out, $temp, $tipo, $nome)
{
    $arquivo_in = $in . $nome;
    $arquivo_temp_t = $temp . $nome . '.' . $tipo;
    $arquivo_thumb_t = $out . $nome . '.' . 'jpeg';
    unlink($arquivo_thumb_t);
    if (!copy($arquivo_in, $arquivo_temp_t)) {

    } else {
        $im = new imagick($arquivo_temp_t);
        $im->cropThumbnailImage(120, 120);
        $im->writeImage($arquivo_thumb_t);

        unlink($arquivo_temp_t);
    }
}

function salvar_imagem_avatar($usuario_id, $arquivo,$croped_image, $caminho=0)
{


    $file_path_1 = __DIR__.'/../file/avatar/';
    $file_thumb1 = __DIR__.'/../file/thumb/';
    $file_temp1 = __DIR__.'/../file/temp/';

    $file_name = $arquivo['name'];
    $file_type = $arquivo['type'];
    $file_size = $arquivo['size'];
    $file_tmp_name = $arquivo['tmp_name'];
    $file_error = $arquivo['error'];
    $origem =  $GLOBALS['file_avatar']['origem'];
    if ($arquivo == null) {
        return 1;
    } else {
        if(!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp|jpg)$/', $file_type)) {
            return '<h3 class="text-danger">Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo </h3>';
        } else {
            $query = 'SELECT id, pathnamehash FROM cvs_files WHERE filetype=1 and userid=' . $usuario_id;
            $resultado = bd_query($query, $_SESSION['conexao'], 0);
            $dado = bd_fetch_array($resultado);
            if ($dado['id'] != 0) {
                $resultado = true;
                if ($resultado) {
                    unlink($file_path_1 . $dado['pathnamehash']);
                    unlink($file_thumb1 . $dado['pathnamehash']);

                    list($type, $croped_image) = explode(';', $croped_image);
                    list(, $croped_image) = explode(',', $croped_image);
                    $croped_image = base64_decode($croped_image);
                    file_put_contents($file_path_1 . $dado['pathnamehash'], $croped_image);
                    gera_thumb($file_path_1, $file_thumb1, $file_temp1, 'jpeg', $dado['pathnamehash']);
                    return 1;
                } else {
                    return '<h3 class="text-danger">' . lang('funcao_salvar_imagem_avatar_mensagem_nao_foi_possivel_salvar_a_foto', 1) . ' </h3>';
                }


            } else {
                $file_salt = base64_encode(rand_bytes(8, true));
                $nome_final = sha1($file_name . $file_salt);
                $query = "INSERT INTO cvs_files( pathnamehash, filepath, filename, userid, filesize, mimetype, status, timecreated, timemodified, filetype, filesalt) VALUES ('$nome_final','" . $GLOBALS['file_avatar']['path'] . "', '$file_name', $usuario_id,$file_size,'$file_type',1,'" . dataHoraAtual() . "','" . dataHoraAtual() . "',$origem,'$file_salt')";
                $resultado = bd_query($query, $_SESSION['conexao'], 0);
                if ($resultado) {

                    list($type, $croped_image) = explode(';', $croped_image);
                    list(, $croped_image) = explode(',', $croped_image);
                    $croped_image = base64_decode($croped_image);

                    file_put_contents($file_path_1 . $nome_final, $croped_image);
                    gera_thumb($file_path_1, $file_thumb1, $file_temp1, 'jpeg', $nome_final);

                    return 1;
                } else {
                    return '<h3 class="text-danger">' . lang('funcao_salvar_imagem_avatar_mensagem_nao_foi_possivel_salvar_a_foto', 1) . ' </h3>';
                }
            }
        }
    }
}

function verifica_anexo_file($arquivo)
{

    $file_name = $arquivo['name'];
    $file_type = $arquivo['type'];
    $file_size = $arquivo['size'];
    $file_tmp_name = $arquivo['tmp_name'];
    $file_error = $arquivo['error'];
    $user_id = $_SESSION['usuario']['id'];
    $origem = $GLOBALS['file_anexo']['origem'];

    if ($file_error != 0) {
        return 0;
    } else {
        $query = 'SELECT id, pathnamehash FROM cvs_files WHERE filetype=' . $origem . ' and userid=' . $user_id;
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        if (bd_num_rows($resultado) > 0) {
            $arq = bd_fetch_array($resultado);
            $nome_final = $arq['pathnamehash'];
            if (array_search($file_type, $GLOBALS['file_anexo']['extensoes']) === false) {
                return 0;
            } else {
                if ($file_anexo['size'] < $file_size) {
                    return 0;
                } else {
                    $query = "UPDATE cvs_files SET filename='" . $file_name . "',filesize=" . $file_size . ",mimetype='" . $file_type . "',timemodified='".dataHoraAtual()."' WHERE filetype=3 and userid=" . $user_id;
                    $resultado = bd_query($query, $_SESSION['conexao'], 0);
                    if ($resultado) {
                        if (move_uploaded_file($file_tmp_name, $file_path_3 . $GLOBALS['file_anexo']['path'] . $nome_final)) {
                            return 2;
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                }
            }
        } else {

            if (array_search($file_type, $GLOBALS['file_anexo']['extensoes']) === false) {
                return "<h3 class='text-danger'>". lang('funcoes_envie_arquivos_seguintes_extensoes',1) ."</h3>";
            } else {
                if ($GLOBALS['file_anexo']['size'] < $file_size) {
                    return "<h3 class='text-danger'>". lang('funcoes_arquivo_muito_grande_2mb',1) ."</h3>";
                } else {
                    if ($file_anexo['renomeia'] == true) {
                        $file_salt = base64_encode(rand_bytes(8, true));
                        $nome_final = sha1($file_name . $file_salt);
                        $query = "INSERT INTO cvs_files( pathnamehash, filepath, filename, userid, filesize, mimetype, status, timecreated, timemodified, filetype, filesalt) VALUES ('$nome_final','" . $file_anexo['path'] . "', '$file_name', $user_id,$file_size,'$file_type',1,'".dataHoraAtual()."','".dataHoraAtual()."',$origem,'$file_salt')";
                        $resultado = bd_query($query, $_SESSION['conexao'], 0);
                        if ($resultado) {
                            if (move_uploaded_file($file_tmp_name, $file_path_3 . $GLOBALS['file_anexo']['path'] . $nome_final)) {
                                return 1;
                            } else {
                                return 0;
                            }
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                }
            }
        }
    }
}

function verificar_acesso_perfil($id_mentorado, $id_mentor, $conexao){ # Verifica se o usuário tem acesso ao perfil indicado.

    $query = "SELECT id FROM cvsmentoria WHERE mentor_id = '$id_mentor' AND solicitante_id = '$id_mentorado'";
    $resultado = bd_query($query, $conexao, 0);

    return bd_num_rows($resultado) > 0;
}

function get_mentor($mentorado_id){ # Retorna o nome e o id do mentor do mentorado
    $query = "SELECT u.nome AS mentor, m.mentor_id AS id_mentor FROM cvsmentoria AS m JOIN cvsusuario_usuarios AS u ON m.mentor_id = u.id WHERE m.status=1 and solicitante_id = '$mentorado_id'";

    return bd_fetch_assoc(bd_query($query, $_SESSION['conexao'], 0));
}

function get_existe_conexoes_mentor_mentorado($mentor_id,$mentorado_id){
    $query = "SELECT id FROM cvsmentoria as m WHERE  ((m.mentor_id = $mentorado_id AND m.solicitante_id = $mentor_id) OR (m.solicitante_id = $mentorado_id AND m.mentor_id = $mentor_id))";
    return bd_num_rows(bd_query($query, $_SESSION['conexao'], 0));
}

function verifica_avaliacao_sessao($id_mentoria, $usuario_id){ # Verifica se o usuario pode avaliar a mentoria

    $query = "SELECT * FROM cvsatividades WHERE id = ".(int)$id_mentoria;
    $resultado = bd_query($query, $_SESSION['conexao'], 0);


    if(bd_num_rows($resultado) > 0){

        $dados = bd_fetch_assoc($resultado);
        $hoje = date("Y-m-d H:i:s");
        $tipo_usuario = get_tipo_usuario($usuario_id);

        if($dados['mentor_id']==$_SESSION['usuario']['id']){
            $realizada=$dados['realizada'];
        }else{
            $realizada=$dados['realizada_emp'];
        }

        if($realizada == 0){
                if (($dados['status'] == 1 || $dados['status'] == 0) && (strtotime($hoje) > strtotime(date("Y-m-d H:i:s",strtotime($dados['fim']." -".TEMPO_AVALIACAO." minutes"))))) {
                    if ($dados['solicitante_id'] == $usuario_id || $dados['solicitado_id'] == $usuario_id) {
                        $response['msg'] = 'OK';
                        $response['atividade']=$dados;
                    } else {
                        $response['msg'] = lang('funcoes_nao_possui_vinculo_mentoria',1);
                    }
                } else {
                    $response['msg'] = lang('funcoes_mentoria_indisponivel_avaliacao',1);
                }
            #}
        } else {
            $response['msg'] = lang('funcoes_ja_avaliou_essa_mentoria',1);
        }
    } else {
        $response['msg'] = lang('funcoes_mentoria_nao_encontrada',1);
    }

    if($response['msg'] != 'OK'){
        $sessoes_avaliar = sessoes_para_avaliar($usuario_id);
        //$response['url'] = $sessoes_avaliar ? '../avaliacao/avaliacao?id=' . $sessoes_avaliar : '';
        $response['url'] = '';

    }

    return $response;
}

function verifica_avaliacao_mentoria($id_mentoria, $usuario_id){ # Verifica se o usuario pode avaliar a mentoria

    $query = "SELECT * FROM cvsmentoria WHERE id = ".(int)$id_mentoria;
    $resultado = bd_query($query, $_SESSION['conexao'], 0);


    if(bd_num_rows($resultado) > 0){

        $dados = bd_fetch_assoc($resultado);
        $hoje = date("Y-m-d H:i:s");
        $tipo_usuario = get_tipo_usuario($usuario_id);

        if($dados['mentor_id']==$_SESSION['usuario']['id']){
            $realizada=$dados['finalizado_mentor'];
        }else{
            $realizada=$dados['finalizado_solicitante'];
        }

        if($realizada == 0){
            if (($dados['status'] == 1 || $dados['status'] == 0)) {

                if ($dados['mentor_id'] == $usuario_id || $dados['solicitante_id'] == $usuario_id) {
                    $response['msg'] = 'OK';
                    $response['mentoria']=$dados;
                } else {
                    $response['msg'] = lang("avaliacao_mensagem_por_favor_informe_motivo",1);
                }
            } else {
                $response['msg'] = lang("avaliacao_mensagem_esta_mentoria_nao_esta_disponivel",1);
            }
        } else {
            $response['msg'] = lang("avaliacao_mensagem_voce_ja_avaliou_mentoria",1);
        }
    } else {
        $response['msg'] = lang("avaliacao_mensagem_mentoria_nao_encontrada",1);
    }

    if($response['msg'] != 'OK'){
        //$sessoes_avaliar = sessoes_para_avaliar($usuario_id);
        $response['url'] = '';
    }

    return $response;
}

function sessoes_para_avaliar($user_id){ # Valida se o o usuario tem sessoes pendentes de avaliação, retorna o id de uma sessão, retorna 0 se não tiver nenhuma

    $query = "SELECT * FROM cvsatividades 
                WHERE (status = 1 OR status = 0) AND fim < '".dataHoraAtual()."'
                AND (solicitante_id = $user_id OR solicitado_id = $user_id)
                AND IF(mentor_id = $user_id, IF(realizada = 0, 1, 0), IF(realizada_emp = 0, 1, 0)) = 1
                ORDER BY fim ASC LIMIT 1";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);

    if(bd_num_rows($resultado) > 0) {
        $atividade = bd_fetch_assoc($resultado);
        $response = $atividade['id'];
    }else{
        $response = 0;
    }

    return $response;
}

function valida_nota($nota, $min_nota = 1, $max_nota = 5, $decimal_precision = 0){ # Valida a nota da avaliação

    if($nota < $min_nota){
        $nota = $min_nota;
    }else if($nota > $max_nota){
        $nota = $max_nota;
    }else{
        $nota = round($nota, $decimal_precision);
    }

    return $nota;

}

function valida_avaliacao_final($usuario_id){ # Só vai ser possível avaliar se o projeto estiver finalizado e se ele não avaliou ainda

    if(is_avaliacao_final($_SESSION['conexao'])){
        $response = ja_avaliou_final($usuario_id)? lang('funcoes_avaliacao_realizada',1) : 'OK';
    } else {
        $response = lang('funcoes_nao_disponivel_avaliacao',1);
    }

    return $response;
}

function is_avaliacao_final(){ # Verifica se o projeto está finalizado
    /*
    $query = "SELECT * FROM cvsavaliacao_final WHERE status = 1";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);

    return bd_num_rows($resultado) > 0;
*/
    return 0;
}

function ja_avaliou_final($usuario_id){ # Verifica se o usuário já avaliou

    $query = "SELECT * FROM cvsavaliacao WHERE usuario_id = $usuario_id";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);

    return bd_num_rows($resultado) > 0;
}

function get_mentorados_mentor($mentor_id){ # Retorna todos os mentorados conectados com o mentor

    $query = "SELECT m.id as id, u.nome as nome FROM cvsmentoria AS m 
                JOIN cvsusuario_usuarios AS u ON m.solicitante_id = u.id
                WHERE m.mentor_id = $mentor_id AND m.status = 1";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);

    if(bd_num_rows($resultado) > 0){
        while($dados = bd_fetch_assoc($resultado)){
            $response[$dados['id']] = $dados['nome'];
        }
        $response['error'] = '';
    }else{
        $response['error'] = lang('funcoes_nao_encontrados_mentorados_mentor',1) ;
    }

    return $response;
}

function get_conexoes($mentor_id){

    $query = "SELECT if(u.id=".$_SESSION['usuario']['id'].",u2.id,u.id) as id, 
    if(u.id=".$_SESSION['usuario']['id'].",u2.nome,u.nome) as nome,solicitante_id,
    mentor_id,m.id as mentoria_id, p.nome as pilar, p.nome_eng as pilar_eng, p.nome_esp as pilar_esp
    FROM cvsmentoria AS m 
                JOIN cvsusuario_usuarios AS u ON m.solicitante_id = u.id
                JOIN cvsusuario_usuarios AS u2 ON m.mentor_id = u2.id
                LEFT JOIN cvspilares AS p ON m.area_id=p.id
                WHERE (m.mentor_id = $mentor_id OR m.solicitante_id = $mentor_id) AND m.status = 1 AND m.tipo=0";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);
    while($dados = bd_fetch_assoc($resultado)){
        $dados['qtd'] = getEtapaMentoria($dados['solicitante_id'], $dados['mentor_id'], $dados['mentoria_id']);
        $dados['nomeEarea']= resume_nome($dados['nome'])." - ".langBD($dados,'pilar',1);
        $response[] =$dados;
    }

    return $response;
}

function is_conectado($mentoria_id, $usuario_id, $mentorado = true){ # Verifica se o usuario esta conectado com a mentoria

    $where = $mentorado ? "solicitante_id = $usuario_id" : "mentor_id = $usuario_id";
    $query = "SELECT * FROM cvsmentoria WHERE id = $mentoria_id AND $where";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);

    return bd_num_rows($resultado) > 0;
}

function verifica_mentorados_avaliados($mentor_id){ # Verifica se todos os mentorados do mentor foram avaliados, retorna true se todos foram, false senão
    $query = "SELECT id, av_disponibilidade_mentorado FROM cvsmentoria WHERE m.mentor_id = $mentor_id AND status = 1 AND (av_disponibilidade_mentorado IS NULL OR av_disponibilidade_mentorado = 0)";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);
    return bd_num_rows($resultado) == 0;
}

function get_tipo_usuario($usuario_id){ # Retorna se o usuario é mentor (2) ou mentorado (1)

    $query = "SELECT regra_id FROM cvsusuario_usuarios WHERE id = $usuario_id";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);
    $dados = bd_fetch_assoc($resultado);
    return $dados['regra_id'];
}

function has_mentorado($usuario_id){ # Verifica se o mentor tem mentorado

    $query = "SELECT * FROM cvsmentoria WHERE solicitante_id=$usuario_id or mentor_id = $usuario_id";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);
    return bd_num_rows($resultado) > 0;
}

function get_mentor_mentorado_sessao($sessao_id){ # Retorna o id do mentor e do mentorado da sessão
    $query = "SELECT mentor_id, mentorado_id FROM cvsatividades WHERE id = $sessao_id";
    return bd_fetch_assoc(bd_query($query, $_SESSION['conexao'], 0));
}

function has_permissao_sessao($mentor_id, $mentorado_id,  $sessao_id = false){ # Verifica se os usuarios podem alterar/adicionar sessões (se estão conectados).
    $response=false;
    if($sessao_id){
        $resp=get_mentor_mentorado_sessao($sessao_id);
        $id_mentorado = $resp['mentorado_id'];
        $id_mentor = $resp['mentor_id'];
        $response = true;
        if($id_mentorado==$_SESSION['usuario']['id'] || $id_mentor==$_SESSION['usuario']['id']){
            $response = true;
        }
    }else{
        if(get_existe_conexoes_mentor_mentorado($mentor_id, $mentorado_id)>0){
            $response = true;
        }
    }
    return $response;
}

function valida_data_hora($data, $hora_inicio, $hora_fim){ # Valida a data e a hora da sessão

    $data_inicio = $data. ' ' .$hora_inicio;
    $data_fim = $data. ' ' .$hora_fim;

    $timeInicio = strtotime(salva_data_hora($data, $hora_inicio));
    $timeFim = strtotime(salva_data_hora($data, $hora_fim));
    $timeNow = strtotime('now');

   // if($timeFim > $timeNow) {

        if ($timeFim > $timeInicio) {

            if (validateDate($data_inicio) && validateDate($data_fim)) {

                $dateFinal = DateTime::createFromFormat('d/m/Y H:i', $data_fim);
                $dateInicio = DateTime::createFromFormat('d/m/Y H:i', $data_inicio);

                $dif = $dateFinal->diff($dateInicio);

                if ($dif->d > 0) {
                    $resp = true;
                } else if ($dif->h > 0) {
                    $resp = true;
                } else if ($dif->i >= 30) {
                    $resp = true;
                } else {
                    $resp = false;
                }

                $response = $resp ? '' : lang('funcoes_tempo_minimo_minutos',1);

            } else {
                $response = lang('funcoes_datas_invalidas',1);
            }
        } else {
            $response = lang('funcoes_data_inicial_maior_final',1);
        }
   /* }else{
        $response = 'Data já passou!';
    } */
    return $response;
}

function validateDate($date, $format = 'd/m/Y H:i'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function is_mentor_mentorado_conectado($mentor_id, $mentorado_id){

    $query = "SELECT * FROM cvsmentoria WHERE (solicitante_id = $mentorado_id AND mentor_id = $mentor_id) OR (mentor_id = $mentorado_id AND solicitante_id = $mentor_id)";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);
    $individual=bd_num_rows($resultado);

    $query = "SELECT * FROM cvsmentoria as m JOIN cvsmentoria_mentorados as mm on m.id=mm.mentoria_id and mm.mentorado_id=$mentorado_id
    WHERE  mentor_id = $mentor_id";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);
    $grupo1=bd_num_rows($resultado);

    $query = "SELECT * FROM cvsmentoria as m JOIN cvsmentoria_mentorados as mm on m.id=mm.mentoria_id and mm.mentorado_id=$mentor_id
    WHERE  mentor_id = $mentorado_id";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);
    $grupo2=bd_num_rows($resultado);

    return ($individual + $grupo1 + $grupo2) > 0;
}

function insere_visualizacao_usuario_para_usuario($user_id, $interaction_id, $origem)
{
    if ($user_id != $interaction_id) {
        $query = 'SELECT id, user_id, interaction_id, origem, time, flag, alvo_id FROM cvsinteraction WHERE user_id=' . $user_id . ' and interaction_id=' . $interaction_id . ' and origem=' . $origem;
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        if (bd_num_rows($resultado) > 0) {

        } else {
            $query = 'INSERT INTO cvsinteraction(user_id, interaction_id, origem, time, alvo_id) VALUES (' . $user_id . ',' . $interaction_id . ',' . $origem . ', \''.dataHoraAtual().'\',' . $interaction_id . ')';
            bd_query($query, $_SESSION['conexao'], 0);
        }
    }

    return;
}

/* * ***************************************************

  Suporte

 * ************************************************** */

function salva_suporte($user_id, $assunto, $descricao)
{
    if ($assunto != '' && $descricao != '') {
        $query = 'INSERT INTO cvssuporte(usuario_id, descricao, criado_em, alterado_em, status, assunto) VALUES ("' . $user_id . '","' . $descricao . '", \''.dataHoraAtual().'\', \''.dataHoraAtual().'\',0,"' . $assunto . '")';
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        $id=bd_last_id();
        $query = "Select id,nome,regra_id,email,idioma from cvsusuario_usuarios where id=" . $user_id;
        $solicitante = bd_query($query, $_SESSION['conexao'], 0);
        $solicitante = bd_fetch_array($solicitante);

        $descricao=preg_replace("/\\r\\n/", "\r\n", $descricao);
        $resultado=enviar_suporte($solicitante,"Suporte - ".$_SESSION['parametros']['projeto_nome']." #".$id,str_replace('\r\n',"<br>",$descricao),$solicitante);
        if ($resultado) {
            return '<div class="alert alert-success alert-dismissable" align="center">
                  <h3>'.lang('suporte_mensagem_enviado_sucesso',1).'</h3>
                  <h5>'.lang('suporte_mensagem_enviado_informações',1).'</h5> 
                   </div>';
        } else {
            return '<div class="alert alert-danger alert-dismissable" align="center">
                  <h3>'.lang('suporte_mensagem_nao_foi_possivel_enviar',1).'</h3>
                   </div>';
        }
    } else {
        return '<div class="alert alert-danger alert-dismissable" align="center">
                  <h3>'.lang('suporte_mensagem_preencha_assunto_e_descricao',1).'</h3>
                   </div>';
    }
}

function tratar_link($link)
{
    $link = str_replace('http://', '', $link);
    $link = str_replace('https://', '', $link);

    return $link;
}

function encrypt_password_profile($password, $salt)
{

    return base64_encode(pbkdf2_calc('sha1', $password, $salt, 10000, strlen($password * 2)));
}

function dd($var, $die = 1)
{
    echo "<pre style=\"background-color: #fff;\">";
    echo var_dump($var) . "</pre>";
    if ($die) {
        die();
    }
}

//Datatable

function limit($request, $columns)
{
    $limit = '';

    if (isset($request['start']) && $request['length'] != -1) {
        $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
    }

    return $limit;
}

function order($request, $columns)
{
    $order = '';

    if (isset($request['order']) && count($request['order'])) {
        $orderBy = array();
        $dtColumns = pluck($columns, 'dt');

        for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
            // Convert the column index into the column data property
            $columnIdx = intval($request['order'][$i]['column']);
            $requestColumn = $request['columns'][$columnIdx];

            $columnIdx = array_search($requestColumn['data'], $dtColumns);
            $column = $columns[$columnIdx];

            if ($requestColumn['orderable'] == 'true') {
                $dir = $request['order'][$i]['dir'] === 'asc' ?
                    'ASC' :
                    'DESC';

                $orderBy[] = '' . $column['db'] . ' ' . $dir;
            }
        }

        $order = 'ORDER BY ' . implode(', ', $orderBy);
    }

    return $order;
}

function filter($request, $columns, &$bindings)
{
    $globalSearch = array();
    $columnSearch = array();
    $dtColumns = pluck($columns, 'dt');

    if (isset($request['search']) && $request['search']['value'] != '') {
        $str = $request['search']['value'];

        for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search($requestColumn['data'], $dtColumns);
            $column = $columns[$columnIdx];

            if ($requestColumn['searchable'] == 'true') {
                $binding = bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                $globalSearch[] = "" . $column['db'] . " LIKE " . $binding;
            }
        }
    }

    // Individual column filtering
    for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
        $requestColumn = $request['columns'][$i];
        $columnIdx = array_search($requestColumn['data'], $dtColumns);
        $column = $columns[$columnIdx];

        $str = $requestColumn['search']['value'];

        if ($requestColumn['searchable'] == 'true' &&
            $str != ''
        ) {
            $binding = bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
            $columnSearch[] = "" . $column['db'] . " LIKE " . $binding;
        }
    }

    // Combine the filters into a single string
    $where = '';

    if (count($globalSearch)) {
        $where = '(' . implode(' OR ', $globalSearch) . ')';
    }

    if (count($columnSearch)) {
        $where = $where === '' ?
            implode(' AND ', $columnSearch) :
            $where . ' AND ' . implode(' AND ', $columnSearch);
    }

    if ($where !== '') {
        $where = 'WHERE ' . $where;
    }

    return $where;
}

function simple($request, $sql_details, $table, $primaryKey, $columns)
{
    $bindings = array();
    $db = sql_connect($sql_details);

    // Build the SQL query string from the request
    $limit = limit($request, $columns);
    $order = order($request, $columns);
    $where = filter($request, $columns, $bindings);

    // Main query to actually get the data
    $data = sql_exec($db, $bindings, "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", pluck($columns, 'db')) . "
       FROM $table
       $where
       $order
       $limit"
    );

    // Data set length after filtering
    $resFilterLength = sql_exec($db, "SELECT FOUND_ROWS()"
    );
    $recordsFiltered = $resFilterLength[0][0];

    // Total data set length
    $resTotalLength = sql_exec($db, "SELECT COUNT({$primaryKey})
       FROM   $table"
    );
    $recordsTotal = $resTotalLength[0][0];


    return array(
        "draw" => intval($request['draw']),
        "recordsTotal" => intval($recordsTotal),
        "recordsFiltered" => intval($recordsFiltered),
        "data" => data_output($columns, $data),
    );
}

function sql_connect($sql_details)
{
    try {
        $db = @new PDO(
            "mysql:host={$sql_details['host']};dbname={$sql_details['db']}", $sql_details['user'], $sql_details['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
    } catch (PDOException $e) {
        fatal(
            "An error occurred while connecting to the database. " .
            "The error reported by the server was: " . $e->getMessage()
        );
    }

    return $db;
}

function sql_exec($db, $bindings, $sql = null)
{
    // Argument shifting
    if ($sql === null) {
        $sql = $bindings;
    }

    $stmt = $db->prepare($sql);
    //echo $sql;
    // Bind parameters
    if (is_array($bindings)) {
        for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
            $binding = $bindings[$i];
            $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
        }
    }

    // Execute
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        fatal("An SQL error occurred: " . $e->getMessage());
    }

    // Return all
    return $stmt->fetchAll();
}

function fatal($msg)
{
    echo json_encode(array(
        "error" => $msg,
    ));

    exit(0);
}

function bind(&$a, $val, $type)
{
    $key = ':binding_' . count($a);

    $a[] = array(
        'key' => $key,
        'val' => $val,
        'type' => $type,
    );

    return $key;
}

function pluck($a, $prop)
{
    $out = array();

    for ($i = 0, $len = count($a); $i < $len; $i++) {
        $out[] = $a[$i][$prop];
    }

    return $out;
}

/* * *********************************************************
  //Datatable Generico
 * ********************************************************** */

function simple_generico($request, $table, $primaryKey, $columns, $where_default, $where_session, $acao, $flag, $group)
{
    //echo 'cheguei';
    $limit = limit($request, $columns);
    //echo $limit;
    $order = order($request, $columns);
    //echo $order;
    $where = filter_generico($request, $columns, $where_default, $where_session);


    $query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", pluck($columns, 'db')) . "
       FROM $table
       $where
       $group
       $order
       $limit";

    //echo $query;
    $resultado = bd_query($query, $_SESSION['conexao'], $flag);
    while ($dado = bd_fetch_array($resultado)) {
        $data[] = $dado;
    }

    //var_dump($data);

    //Sessão da consulta executada
    $_SESSION['filtro'] = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", pluck($columns, 'db')) . "
       FROM $table
       $where
       $group
       $order
       $limit";

    $query = "SELECT FOUND_ROWS()";
    $resFilterLength = bd_query($query, $_SESSION['conexao'], $flag);
    $resFilterLength = bd_fetch_array($resFilterLength);
    $recordsFiltered = $resFilterLength[0];

    $query = "SELECT COUNT({$primaryKey})
       FROM  $table";
    $resTotalLength = bd_query($query, $_SESSION['conexao'], $flag);
    $resTotalLength = bd_fetch_array($resTotalLength);
    $recordsTotal = $resTotalLength[0];

    return array(
        "draw" => intval($request['draw']),
        "recordsTotal" => intval($recordsTotal),
        "recordsFiltered" => intval($recordsFiltered),
        "data" => data_output_genericos($columns, $data, $acao),
    );
}

function data_output_genericos($columns, $data, $acao)
{
    $acao_default = $acao;
    $out = array();
    for ($i = 0, $ien = count($data); $i < $ien; $i++) {
        $row = array();
        $count = count($columns);
        for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
            $column = $columns[$j];

            if (isset($column['formatter'])) {
                $row[$column['dt']] = $column['formatter']($data[$i][$column['dt']], $data[$i]);
            } else {
                $row[$column['dt']] = $data[$i][$columns[$j]['dt']];
            }
            if (isset($column['tipo'])) {
                //Formatos Tipos
                if ($column['tipo'] == 'date') {
                    $row[$column['dt']] = cvtdata($row[$column['dt']]);
                }
                if ($column['tipo'] == 'datetime') {
                    $row[$column['dt']] = cvtdatacompleta($row[$column['dt']]);
                }
                if ($column['tipo'] == "float" || $column['tipo'] == "double" || $column['tipo'] == "decimal") {
                    $row[$column['dt']] = number_format($row[$column['dt']], 2, ',', '.');
                }
            }
        }

        if ($acao != '') {
            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $acao = str_replace('$row[' . $j . ']', $row[$j], $acao);
            }
            $row[$count] = $acao;
        }
        $acao = $acao_default;
        $row['DT_RowId'] = $_SESSION['line_id'] . $row[0];
        $out[] = $row;
    }

    //var_dump($rows);

    return $out;
}

function filter_generico($request, $columns, $where_default, $where_session)
{
    $globalSearch = array();
    $columnSearch = array();
    $dtColumns = pluck($columns, 'dt');

    if (isset($request['search']) && $request['search']['value'] != '') {
        $str = $request['search']['value'];

        for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search($requestColumn['data'], $dtColumns);
            $column = $columns[$columnIdx];

            if ($requestColumn['searchable'] == 'true') {
                if ($column['where'] == 'not') {

                } else {
                    $globalSearch[] = "" . $column['db'] . " LIKE " . '\'%' . $str . '%\'';
                    $globalSearch[] = "" . $column['db'] . " LIKE " . '\'%' . seguro($str) . '%\'';
                }
            }
        }
    }
    for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
        $requestColumn = $request['columns'][$i];
        $columnIdx = array_search($requestColumn['data'], $dtColumns);
        $column = $columns[$columnIdx];
        $str = $requestColumn['search']['value'];
        if ($requestColumn['searchable'] == 'true' &&
            $str != ''
        ) {
            if ($column['where'] == 'not') {

            } else {
                $columnSearch[] = "" . $column['db'] . " LIKE " . '\'%' . $str . '%\'';
            }
        }
    }
    $where = '';
    if (count($globalSearch)) {
        $where = '(' . implode(' OR ', $globalSearch) . ')';
    }
    if (count($columnSearch)) {
        $where = $where === '' ?
            implode(' AND ', $columnSearch) :
            $where . ' AND ' . implode(' AND ', $columnSearch);
    }


    if ($where_session != '' || $where != '' || $where_default != '') {
        if ($where !== '') {
            $where = $where . ' and';
        }
        $where = 'Where ' . $where_default . $where_session . $where;
        $tamanho = strlen($where);
        $tamanho = $tamanho - 3;
        $where = substr($where, 0, $tamanho);
    }


    return $where;
}

function cvtdata($data)
{
    if (trim($data) == '0000-00-00') {
        return '';
    }
    if (trim($data) != '') {
        $ano = substr($data, 0, 4);
        $mes = substr($data, 5, 2);
        $dia = substr($data, 8, 2);
        //echo $ano.' - '.$mes.' - '.$dia;
        $data = date('d/m/Y', mktime(0, 0, 0, $mes, $dia, $ano));

        return $data;
    } else {
        return '';
    }
}

function busca_atividades_home( $usuario_id, $limite = 5,$status, $order, $mentor_id = -1){ # Lista somente as mentorias a serem realizadas.

    $projeto_encerrado = is_avaliacao_final($_SESSION['conexao']);

    if($mentor_id == -1) {

    }else{
        $mentorStatus="a.mentor_id=$mentor_id and ";
    }

    $query = "SELECT 
     a.id AS id, 
     a.solicitante_id AS solicitante_id,
     a.solicitado_id AS solicitado_id,
     a.atividade_tipo_id AS atividade_tipo_id, 
     a.obs,
     a.obs_mentor AS obs_mentor,
     a.inicio AS inicio,
     a.fim AS fim,
     a.url AS url,
     a.dia_todo AS dia_todi,
     a.solicitante_confirmacao AS solicitante_confirmacao, 
     a.solicitado_confirmacao AS solicitado_confirmacao,
     t.nome AS nomeAtividade, 
     t.nome_eng AS nomeAtividade_eng,
     t.nome_esp AS nomeAtividade_esp,   
     t.ativar_link,
     a.link_atividade,
     u.nome AS nomeMentor,
     a.status AS status,
     a.realizada_emp AS realizada_emp,
     a.realizada AS realizada,
     a.atividade AS atividade,
     a.descricao AS descricao,
     a.mentorado_id,
     a.mentor_id,
     a.atividade_tipo,
     a.mentoria_id
     FROM cvsatividades AS a
     LEFT JOIN cvsatividades_tipo AS t ON a.atividade_tipo_id=t.id
     JOIN cvsusuario_usuarios AS u ON IF(a.solicitante_id = $usuario_id, a.solicitado_id, a.solicitante_id) = u.id
     WHERE atividade_tipo=0 and $mentorStatus (a.solicitante_id = $usuario_id OR solicitado_id = $usuario_id) AND deletada <> 1  AND $status ORDER BY $order "
            .($limite == 0 ? "" : "LIMIT ".$limite);


    $dados = bd_query($query, $_SESSION['conexao'], 0);

    $hoje = date("Y-m-d H:i:s");
    $response=array();
    while ($dado = bd_fetch_array($dados)){
        $data= $dado;
        $data['status_id']=$dado['status'];
        $query = "Select id,nome,regra_id from cvsusuario_usuarios where id=" . $dado['solicitante_id'];
        $solicitante = bd_query($query, $_SESSION['conexao'], 0);
        $solicitante = bd_fetch_array($solicitante);

        $query = "Select id,nome,regra_id from cvsusuario_usuarios where id=" . $dado['solicitado_id'];
        $solicitado = bd_query($query, $_SESSION['conexao'], 0);
        $solicitado = bd_fetch_array($solicitado);

        $data['ignore'] = false;
        $bloq_btn = true;

        $dado['solicitado_regra_id']= $solicitado['regra_id'];
        $dado['solicitante_regra_id']= $solicitante['regra_id'];

        if($mentor_id == -1) {

            if($dado['atividade_tipo']==0){
                $data = conferir_data_botoes($usuario_id, $data, $dado);
            }else if($dado['atividade_tipo']==1 || $dado['atividade_tipo']==2){
                $data = conferir_data_botoes_grupo($usuario_id, $data, $dado);
            }

        }else{

            if($dado['atividade_tipo']==0){
                $data = conferir_data_botoes($mentor_id, $data, $dado);
            }else if($dado['atividade_tipo']==1 || $dado['atividade_tipo']==2){
                $data = conferir_data_botoes_grupo($mentor_id, $data, $dado);
            }

        }


        if ($dado['solicitante_id'] == $usuario_id) {
            $data['solicitante_nome']=$dado['solicitante_nome'];
        }else{
            $data['solicitante_nome']=$dado['solicitado_nome'];
        }

        if ($dado['solicitante_id'] == $usuario_id) {
            $data['mostra_nome']=$solicitado['nome'];
            $data['perfil_id']=$solicitado['id'];
        }else{
            $data['mostra_nome']=$solicitante['nome'];
            $data['perfil_id']=$solicitante['id'];
        }

        $data['id'] = $dado['id'];

        $data['atv_id'] = $dado['id'];
        $data['solicitado_id'] = $dado['solicitado_id'];
        $data['nome'] = $dado['nome'];
        $data['nomeMentor'] = $dado['nomeMentor'];
        $data['mentor_id'] = $dado['mentor_id'];
        $data['atividade'] = $dado['atividade'];
        $data['nomeAtividade'] = $dado['nomeAtividade'];
        $data['nomeAtividade_eng'] = $dado['nomeAtividade_eng'];
        $data['nomeAtividade_esp'] = $dado['nomeAtividade_esp'];
        $data['descricao'] = $dado['descricao'];
        $data['inicio'] = $dado['inicio'];
        $data['fim'] = $dado['fim'];
        $data['obs'] = $dado['obs'];
        $data['obs_atividade'] = $dado['obs_atividade'];
        $data['mentorado_id'] = $dado['mentorado_id'];
        $data['mentoria_id'] = $dado['mentoria_id'];
        $data['atividade_tipo'] = $dado['atividade_tipo'];
        $data['atividade_tipo_id'] = $dado['atividade_tipo_id'];

        $data['atv_id'] = $dado['id'];


        if($projeto_encerrado){
            if($bloq_btn) $data['botoes'] = '';
        }

        $response[] = $data;
    }

    return $response;
}

function conferir_data_botoes($usuario_id, $data, $dado)
{

    $hoje = date("Y-m-d H:i:s");
    $data['botoes'] = '';



    if (strtotime($hoje) > strtotime(date("Y-m-d H:i:s",strtotime($dado['fim']." -15 minutes")))) {// Se já acabou

        if ($dado['solicitante_id'] == $usuario_id) {// Se eu sou o solicitante
           // echo $dado['solicitante_id']."- ".$usuario_id." - ".$dado['mentorado_id'];
            if($dado['mentorado_id'] == $usuario_id){ // mentorado
                if ($dado['realizada_emp'] == 0){

                    $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_avaliacao'] . ';">' . $GLOBALS['status_text']['aguardando_avaliacao'] . '</span>';
                    $data['botoes'] = '<button onclick="nao_realizado(\'' . $dado['id'] . '\')" class="btn btn-danger outline"><i class="fa fa-thumbs-down"></i> '.lang('funcao_botao_nao_realizada',1).'</button>&nbsp&nbsp<button onclick="confirma_realizacao(\'' . $dado['id'] . '\')" class="btn btn-success outline"><i class="fa fa-thumbs-up"></i> '.lang('funcao_botao_confirmar_realizacao',1).'</button>';
                }else{
                    $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_avaliacao'] . ';">' . $GLOBALS['status_text']['aguardando_avaliacao'] . lang('funcoes_do_mentor',1) .'</span>';
                    $data['botoes'] = '';
                }
            }else{
                if ($dado['realizada'] == 0){
                    $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_avaliacao'] . ';">' . $GLOBALS['status_text']['aguardando_avaliacao'] . '</span>';
                    $data['botoes'] = '<button onclick="nao_realizado(\'' . $dado['id'] . '\')"  class="btn btn-danger outline"><i class="fa fa-thumbs-down"></i> '.lang('funcao_botao_nao_realizada',1).'</button>&nbsp&nbsp<button onclick="confirma_realizacao(\'' . $dado['id'] . '\')" class="btn btn-success outline"><i class="fa fa-thumbs-up"></i> '.lang('funcao_botao_confirmar_realizacao',1).'</button>';
                }else{
                    $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_avaliacao'] . ';">' . $GLOBALS['status_text']['aguardando_avaliacao'] . lang('funcoes_do_mentorado',1) .'</span>';
                    $data['botoes'] = '';
                }
            }


            if ($dado['status'] == 0) { //Aguardando
                $data['color'] = $GLOBALS['status_color']['aguardando_avaliacao'];

            } else if ($dado['status'] == 1) {// Confirmada

                if ($dado['realizada'] == 0 && $dado['realizada_emp'] == 0) {// Mentoria aguardando avaliação da realização
                    $data['color'] = $GLOBALS['status_color']['aguardando_avaliacao'];
                }
                if ($dado['realizada'] == 1 || $dado['realizada_emp'] == 1) {// Mentoria realizada
                    $data['color'] = $GLOBALS['status_color']['realizada'];
                }
                if ($dado['realizada'] == 2 || $dado['realizada_emp'] == 2) {// Mentoria não realizada
                    $data['color'] = $GLOBALS['status_color']['nao_realizada'];
                }

            } else if ($dado['status'] == 2) {// Rejeitada
                $data['color'] = $GLOBALS['status_color']['rejeitada'];

            } else if ($dado['status'] == 3) {// Realizada
                $data['color'] = $GLOBALS['status_color']['realizada'];

            } else if ($dado['status'] == 4) {// Cancelada
                $data['color'] = $GLOBALS['status_color']['cancelada'];

            }else if ($dado['status'] == 5) {
                $data['color'] = $GLOBALS['status_color']['nao_realizada'];
            }

        } else { // Se eu sou o solicitado

            if($dado['mentorado_id'] == $usuario_id){
                if ($dado['realizada_emp'] == "0"){
                    $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_avaliacao'] . ';">' . $GLOBALS['status_text']['aguardando_avaliacao'] . '</span>';
                    $data['botoes'] = '<button onclick="nao_realizado(\'' . $dado['id'] . '\')" class="btn btn-danger outline"> <i class="fa fa-thumbs-down"></i>  '.lang('funcao_botao_nao_realizada',1).'</button>&nbsp&nbsp<button onclick="confirma_realizacao(\'' . $dado['id'] . '\')" class="btn btn-success outline"><i class="fa fa-thumbs-up"></i> '. lang('funcoes_confirmar_realizacao',1) .'</button>';
                }else{
                    $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_avaliacao'] . ';">' . $GLOBALS['status_text']['aguardando_avaliacao'] . lang('funcoes_do_mentor',1) . '</span>';
                    $data['botoes'] = '';
                }
            }else{
                if ($dado['realizada'] == "0"){
                    $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_avaliacao'] . ';">' . $GLOBALS['status_text']['aguardando_avaliacao'] . '</span>';
                    $data['botoes'] = '<button onclick="nao_realizado(\'' . $dado['id'] . '\')" class="btn btn-danger outline"><i class="fa fa-thumbs-down"></i> '.lang('funcao_botao_nao_realizada',1).'</button>&nbsp&nbsp <button onclick="confirma_realizacao(\'' . $dado['id'] . '\')" class="btn btn-success outline"><i class="fa fa-thumbs-up"></i> '. lang('funcoes_confirmar_realizacao',1) .'</button>';
                }else{
                    $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_avaliacao'] . ';">' . $GLOBALS['status_text']['aguardando_avaliacao'] . lang('funcoes_do_mentorado',1) . '</span>';
                    $data['botoes'] = '';
                }
            }

            if ($dado['status'] == 0) { //Aguardando
                $data['color'] = $GLOBALS['status_color']['aguardando_avaliacao']; // Se ja passou o tempo da mentoria e ngm confirmou (status continua 0), libera para avaliação, ai o usuario dirá se realizou ou não.

            } else if ($dado['status'] == 1) {// Confirmada

                if ($dado['realizada'] == 0 && $dado['realizada_emp'] == 0) {
                    $data['color'] = $GLOBALS['status_color']['aguardando_avaliacao'];
                }
                if ($dado['realizada'] == 1 || $dado['realizada_emp'] == 1) {
                    $data['color'] = $GLOBALS['status_color']['realizada'];
                }
                if ($dado['realizada'] == 2 || $dado['realizada_emp'] == 2) {
                    $data['color'] = $GLOBALS['status_color']['nao_realizada'];
                }

            } else if ($dado['status'] == 2) {// Rejeitada
                $data['color'] = $GLOBALS['status_color']['rejeitada'];

            } else if ($dado['status'] == 3) {// Realizada
                $data['color'] = $GLOBALS['status_color']['realizada'];

            } else if ($dado['status'] == 4) {// Cancelada
                $data['color'] = $GLOBALS['status_color']['cancelada'];

            }else if ($dado['status'] == 5) {
                $data['color'] = $GLOBALS['status_color']['nao_realizada'];
            }
        }
    } else if (strtotime($dado['inicio']) < strtotime($hoje) && strtotime($hoje) < strtotime(date("Y-m-d H:i:s",strtotime($dado['fim']." -15 minutes"))) && $dado['status'] == 1) {// Se está em andamento
        $data['color'] = $GLOBALS['status_color']['andamento'];

        if ($dado['status'] == 0 && $dado['solicitado_confirmacao'] == 0) {// mentor ainda não aceitou ou rejeitou a mentoria
            //mentoria não realizada (não foi confirmada)
            $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['nao_confirmada'] . ';">' . $GLOBALS['status_text']['nao_confirmada'] . '</span>';
           // $data['botoes'] = '<a onclick="deletar_atividade(\'' . $dado['id'] . '\')" class="btn-danger outline">'.lang('funcao_botao_deletar',1).' </a>';
            $data['ignore'] = true;

        } else {
            // em andamento
            $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['andamento'] . ';">' . $GLOBALS['status_text']['andamento'] . '</span>';
            $data['ignore'] = true;
        }

    } else {// se ainda não começou

        if ($dado['solicitante_id'] == $usuario_id) {
            $data['solicitado_nome'] = $solicitado['nome'];

            if ($dado['status'] == 0 && $dado['solicitado_confirmacao'] == 0) {
                $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_confirmacao'] . ';">' . $GLOBALS['status_text']['aguardando_confirmacao'] . '</span>';
                $data['botoes'] = '<a onclick="cancelar_atividade(\'' . $dado['id'] . '\')"  class="btn-danger outline">'.lang('funcao_botao_cancelar_sessao',1).'</a>';
                $data['color'] = $GLOBALS['status_color']['aguardando_confirmacao'];

                if ($dado['solicitante_confirmacao'] == 0) {
                    $data['botoes'] = '
                 <button onclick="rejeitar_atividade(\'' . $dado['id'] . '\')" class="btn btn-danger outline"><i class="fa fa-thumbs-down"></i> '.lang('funcao_botao_rejeitar',1).'</button>
                &nbsp&nbsp<button onclick="aceitar_atividade(\'' . $dado['id'] . '\')" class="btn btn-success outline"><i class="fa fa-thumbs-up"></i> '.lang('funcao_botao_aceitar',1).'</button>
              ';
                }
            }

            if ($dado['solicitado_confirmacao'] == 1) {
                $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['agendada'] . ';">' . $GLOBALS['status_text']['agendada'] . '</span>';
                $data['botoes'] = '<a onclick="cancelar_atividade(\'' . $dado['id'] . '\')"  class="btn-danger outline">'.lang('funcao_botao_cancelar_sessao',1).'</a>';
                $data['color'] = $GLOBALS['status_color']['agendada'];
            }





        } else {
            $data['solicitado_nome'] = $solicitante['nome'];

            if ($dado['status'] == 0 &&  $dado['solicitado_confirmacao'] == 0) {
                $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['aguardando_confirmacao'] . '; ">' . $GLOBALS['status_text']['aguardando_confirmacao'] . '</span>';
                $data['botoes'] = '
                 <button onclick="rejeitar_atividade(\'' . $dado['id'] . '\')" class="btn btn-danger outline"><i class="fa fa-thumbs-down"></i> '.lang('funcao_botao_rejeitar',1).'</button>
                &nbsp&nbsp<button onclick="sugerir_atividade(\'' . $dado['id'] . '\')"  class="btn btn-info outline"><i class="fa fa-calendar"></i> '.lang('funcao_botao_sugerir_nova_data',1).'</button>
                &nbsp&nbsp<button onclick="aceitar_atividade(\'' . $dado['id'] . '\')" class="btn btn-success outline"><i class="fa fa-thumbs-up"></i> '.lang('funcao_botao_aceitar',1).'</button>
              ';
                $data['color'] = $GLOBALS['status_color']['aguardando_confirmacao'];
            }
            if ($dado['solicitado_confirmacao'] == 1) {
                $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['agendada'] . ';">' . $GLOBALS['status_text']['agendada'] . '</span>';
                $data['botoes'] = '<a onclick="cancelar_atividade(\'' . $dado['id'] . '\')" class="btn-danger outline">'.lang('funcao_botao_cancelar_sessao',1).'</a>';
                $data['color'] = $GLOBALS['status_color']['agendada'];
            }
        }
    }



    if ($dado['status'] == 2) {
        $data['color'] = $GLOBALS['status_color']['rejeitada'];
        $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['rejeitada'] . ';">' . $GLOBALS['status_text']['rejeitada'] . '</span>';
       // $data['botoes'] = '<a onclick="deletar_atividade(\'' . $dado['id'] . '\')" class="btn-danger outline">'.lang('funcao_botao_deletar',1).' </a>';
    }else if ($dado['status'] == 5) {
        $data['color'] = $GLOBALS['status_color']['nao_realizada'];
        $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['nao_realizada'] . ';">' . $GLOBALS['status_text']['nao_realizada'] . '</span>';
        $data['botoes'] = '<a onclick="deletar_atividade(\'' . $dado['id'] . '\')" class="btn-danger outline">'.lang('funcao_botao_deletar',1).' </a>';
    }else if ($dado['status'] == 3) {
            $data['color'] = $GLOBALS['status_color']['realizada'];
            $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['realizada'] . ';">' . $GLOBALS['status_text']['realizada'] . '</span>';
            $data['botoes']= '';
    }else if ($dado['status'] == 4) {
            $data['color'] = $GLOBALS['status_color']['cancelada'];
            $data['status'] = '<span class="label" style="color: ' . $GLOBALS['status_color']['cancelada'] . ';">' . $GLOBALS['status_text']['cancelada'] . '</span>';
            $data['botoes'] = '';
    }


    return $data;
}

function drawStars($row,$value_empty){
    if($row != $value_empty){
        $row = floor($row);
        $avaliacao = "";
        $color = ($row < 3 ? "#BC204B":"#EAAA00");
        for($j = 0; $j < 5;$j++){
            if($j < $row)
                $avaliacao .= "<i class='fa fa-star' style='color:$color'></i>";
            else
                $avaliacao .= "<i class='fa fa-star-o'  style='color:$color'></i>";
        }
        return $avaliacao;
    }
    return $row;
}

function pergunta_molde_normalizar($molde_pergunta){

    for($i = 1; $i <= 5;$i++){
        $molde_pergunta = str_replace("#".$i,'0',$molde_pergunta);
    }
    return $molde_pergunta;
}

/* * *******************************************

  Programas


 * ********************************************* */
function busca_all_programs($data, $limit)
{
    $query = "SELECT * FROM cvsprogramas WHERE nome like '%" . $data . "%' " . $limit;
    return bd_query($query, $_SESSION['conexao'], 0);
}

function salva_programas($nome, $eng, $esp)
{
    if ($nome != '') {
        $query = 'INSERT INTO cvsprogramas(nome,nome_eng,nome_esp, status) VALUES ("' . $nome . '","' . $eng . '","' . $esp . '", 1)';
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        if ($resultado) {
            return lang('funcoes_cadastrado_sucesso',1);
        } else {
            return lang('funcoes_erro_gravacao',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function busca_programa_id($id)
{
    $query = "SELECT * FROM cvsprogramas WHERE id=" . (int)$id;

    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function edita_programas($nome, $nome_eng, $nome_esp, $id)
{
    if ($nome != '') {
        $query = 'UPDATE cvsprogramas SET nome="' . $nome . '",nome_eng="' . $nome_eng . '",
        nome_esp="' . $nome_esp . '" WHERE id=' . (int)$id;
        $area = bd_query($query, $_SESSION['conexao'], 0);
        if ($area) {
            return lang('funcoes_editado_sucesso',1);
        } else {
            return lang('funcoes_erro_gravacao',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function get_programas(){
    $query = "SELECT * FROM cvsprogramas WHERE status = 1 order by nome";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    while ($dado = bd_fetch_assoc($dados)) {
        $areas[] = $dado;
    }

    return $areas;
}

/* * *******************************************

  Pilares


 * ********************************************* */
function busca_all_pilares($data, $limit, $tipo=0)
{
    $query = "SELECT * FROM cvspilares WHERE tipo=".$tipo." and nome like '%" . $data . "%' " . $limit;
    return bd_query($query, $_SESSION['conexao'], 0);
}

function salva_pilares($nome,$nome_eng,$nome_esp, $cor, $descricao, $descricao_eng, $descricao_esp, $tipo)
{
    if ($nome != '') {
        $query = 'INSERT INTO cvspilares(nome,nome_eng,nome_esp, status, cor, descricao, descricao_eng, descricao_esp, tipo) 
        VALUES ("' . $nome . '","' . $nome_eng . '","' . $nome_esp . '", 1,"' . $cor . '", "' . $descricao . '",
         "' . $descricao_eng . '", "' . $descricao_esp . '",'.$tipo.')';
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        if ($resultado) {
            return lang('funcoes_cadastrado_sucesso',1);
        } else {
            return lang('funcoes_erro_gravacao',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function busca_pilar_id( $id)
{
    $query = "SELECT * FROM cvspilares WHERE id=" . (int)$id;

    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function edita_pilares($nome,$nome_eng,$nome_esp, $id, $cor, $descricao, $descricao_eng, $descricao_esp)
{
    if ($nome != '') {
        $query = 'UPDATE cvspilares SET nome="' . $nome . '",nome_eng="' . $nome_eng . '",nome_esp="' . $nome_esp . '", 
        cor="'.$cor.'", descricao="'.$descricao.'", descricao_eng="'.$descricao_eng.'", descricao_esp="'.$descricao_esp.'" WHERE id=' . (int)$id;
        $area = bd_query($query, $_SESSION['conexao'], 0);
        if ($area) {
            return lang('funcoes_editado_sucesso',1);
        } else {
            return lang('funcoes_erro_gravacao',1);
            
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function get_pilares($tipo=0){
    $query = "SELECT * FROM cvspilares WHERE status = 1 and tipo=".$tipo." ";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    while ($dado = bd_fetch_assoc($dados)) {
        $areas[] = $dado;
    }

    return $areas;
}

function get_pilares_id(){
    $query = "SELECT * FROM cvspilares WHERE status = 1";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    while ($dado = bd_fetch_assoc($dados)) {
        $areas[$dado['id']] = $dado;
    }

    return $areas;
}

function array_find_element_by_key($key, &$form) {
    if (array_key_exists($key, $form)) {
        $ret =& $form[$key];
        return true;
    }
    foreach ($form as $k => $v) {
        if (is_array($v)) {
            $ret =& array_find_element_by_key($key, $form[$k]);
            if ($ret) {
                return true;
            }
        }
    }
    return false;
}

/* * ***************************************************

  Motivos Cancelamento

 * ************************************************** */

function busca_motivo_cancelamento()
{
    $query = "SELECT * FROM cvsmotivos_cancelamento WHERE status = 1 ORDER BY nome";

    return bd_query($query, $_SESSION['conexao'], 0);
}

function busca_all_motivo_cancelamento()
{
    $query = "SELECT * FROM cvsmotivos_cancelamento ORDER BY nome";

    return bd_query($query, $_SESSION['conexao'], 0);
}

function busca_tipo_motivo_cancelamento_id( $id)
{
    $query = "SELECT * FROM cvsmotivos_cancelamento WHERE id=" . (int)$id;

    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function aditar_motivo_cancelamento( $nome,$nome_eng,$nome_esp, $id)
{
    if ($nome != '') {
        $query = 'UPDATE cvsmotivos_cancelamento SET nome=\''.$nome.'\',nome_eng=\''.$nome_eng.'\',nome_esp=\''.$nome_esp.'\' WHERE id='.(int)$id;
        $resultado = bd_query($query,  $_SESSION['conexao'], 0);
        if ($resultado) {
            return lang('funcoes_editado_sucesso',1);
        } else {
            return lang('funcoes_erro_editar_informacao_aguarde',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function salva_motivo_cancelamento( $nome,$nome_eng,$nome_esp){
    if ($nome != '') {
        $query = 'INSERT INTO cvsmotivos_cancelamento(nome,nome_eng,nome_esp, status) VALUES ( "'.$nome.'","'.$nome_eng.'","'.$nome_esp.'", 1)';
        $resultado = bd_query($query,  $_SESSION['conexao'], 0);
        if ($resultado) {
            return lang('funcoes_cadastro_realizado_sucesso',1);
        } else {
            return lang('funcoes_erro_inserir_informacao_aguarde',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

/* * ***************************************************

  Motivos Cancelamento da Sessão

 * ************************************************** */

function busca_motivo_cancelamento_sessao()
{
    $query = "SELECT * FROM cvsmotivos_cancelamento_sessao WHERE status = 1 ORDER BY nome";

    return bd_query($query, $_SESSION['conexao'], 0);
}

function busca_all_motivo_cancelamento_sessao()
{
    $query = "SELECT * FROM cvsmotivos_cancelamento_sessao ORDER BY nome";

    return bd_query($query, $_SESSION['conexao'], 0);
}

function busca_tipo_motivo_cancelamento_sessao_id( $id)
{
    $query = "SELECT * FROM cvsmotivos_cancelamento_sessao WHERE id=" . (int)$id;

    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function aditar_motivo_cancelamento_sessao( $nome,$nome_eng,$nome_esp, $id)
{
    if ($nome != '') {
        $query = 'UPDATE cvsmotivos_cancelamento_sessao SET nome=\''.$nome.'\', nome_eng=\''.$nome_eng.'\', nome_esp=\''.$nome_esp.'\' WHERE id='.(int)$id;
        $resultado = bd_query($query,  $_SESSION['conexao'], 0);
        if ($resultado) {
            return lang('funcoes_editado_sucesso',1);
        } else {
            return lang('funcoes_erro_inserir_informacao_aguarde',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function salva_motivo_cancelamento_sessao( $nome,$nome_eng,$nome_esp){
    if ($nome != '') {
        $query = 'INSERT INTO cvsmotivos_cancelamento_sessao(nome,nome_eng,nome_esp, status) VALUES ( "'.$nome.'","'.$nome_eng.'","'.$nome_esp.'", 1)';
        $resultado = bd_query($query,  $_SESSION['conexao'], 0);
        if ($resultado) {
            return lang('funcoes_cadastro_realizado_sucesso',1);
        } else {
            return lang('funcoes_erro_inserir_informacao_aguarde',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function etapasMentoria($mentorado_id,$mentor_id, $mentoria){
    $html_status="";
    if($mentoria['tipo']==0){

        $query="SELECT id,status, realizada, realizada_emp FROM cvsatividades 
    where  mentoria_id=".$mentoria['id']." and (status=3 || status=1 || status=0) and 
    mentorado_id=".$mentorado_id." and mentor_id=".$mentor_id. "  ORDER BY fim";
        $resultado_realizada=bd_query($query, $_SESSION['conexao'], 0);

        $query="SELECT id,status, realizada, realizada_emp FROM cvsatividades where  mentoria_id=".$mentoria['id']." and status=0 and mentorado_id=".$mentorado_id." and mentor_id=".$mentor_id." ORDER BY inicio LIMIT 0,1";
        $resultado_andamento=bd_query($query,  $_SESSION['conexao'], 0);


    }else if($mentoria['tipo']==1){

        $query="SELECT id,status, realizada, realizada_emp FROM cvsatividades 
    where  mentoria_id=".$mentoria['id']." and (status=3 || status=1 || status=0) and 
    mentorado_id=0 and mentor_id=".$mentor_id. " and atividade_tipo=1 ORDER BY fim";
        $resultado_realizada=bd_query($query, $_SESSION['conexao'], 0);

        $query="SELECT id,status, realizada, realizada_emp FROM cvsatividades where  mentoria_id=".$mentoria['id']." and status=0 and mentorado_id=0 and mentor_id=".$mentor_id. " and atividade_tipo=1 ORDER BY inicio LIMIT 0,1";
        $resultado_andamento=bd_query($query,  $_SESSION['conexao'], 0);


    }

    $i=0;

    while ($ativ = bd_fetch_assoc($resultado_realizada)) {
        $i++;
       
        if($ativ['status']==3){
            $html_status.='<button type="button" onclick="buscar_sessao('.$ativ['id'].')" class="btnmodify-9 btn btn-primary badge-etapa"  style="background-color:'.$GLOBALS['status_color']['realizada'].';border: '.$GLOBALS['status_color']['realizada'].' 1px solid;" data-toggle="tooltip" data-placement="top" title="'. lang('funcoes_realizada',1) .'">'.$i.'&nbsp;&nbsp;'.lang("status_sessao_realizada",1).'</button>';
        }else if($ativ['status']==1){
            if($ativ['realizada']==0 && $ativ['realizada_emp']==0){
                $html_status.='<button type="button" onclick="buscar_sessao('.$ativ['id'].')" class="btnmodify-10 btn btn-primary badge-etapa"  style="background-color:'.$GLOBALS['status_color']['agendada'].';border: '.$GLOBALS['status_color']['agendada'].' 1px solid;"  data-toggle="tooltip" data-placement="top" title="'. lang('funcoes_agendada',1) .'">'.$i.'&nbsp;&nbsp;'.lang("status_sessao_agendada",1).'</button>';
            }else{
                $html_status.='<button type="button" onclick="buscar_sessao('.$ativ['id'].')" class="btnmodify-8 btn btn-primary badge-etapa"  style="background-color:'.$GLOBALS['status_color']['aguardando_avaliacao'].';border: '.$GLOBALS['status_color']['aguardando_avaliacao'].' 1px solid;"  data-toggle="tooltip" data-placement="top" title="'.lang('funcoes_aguardando_avaliacao',1).'">'.$i.'&nbsp;&nbsp;'.lang("status_sessao_aguarde",1).'</button>';
            }
        }else if($ativ['status']==0){
            $html_status.='<button type="button" onclick="buscar_sessao('.$ativ['id'].')" class="btnmodify-8 btn btn-primary badge-etapa"  style="background-color:'.$GLOBALS['status_color']['aguardando_confirmacao'].';border: '.$GLOBALS['status_color']['aguardando_confirmacao'].' 1px solid;"  data-toggle="tooltip" data-placement="top" title="'.lang('funcoes_aguardando_confirmacao',1).'">'.$i.'&nbsp;&nbsp;'.lang("status_sessao_aguarde",1).'</button>';
        }

    }
    $i++;

    if($mentor_id==$_SESSION['usuario']['id']){
    $user_id=$mentorado_id;
    }else{
        $user_id=$mentor_id;
    }

    if(bd_num_rows($resultado_andamento)==0){
        if($mentoria['status']==1){
            if ($mentoria['finalizado_mentor'] == '0' && $mentoria['finalizado_solicitante'] == '0') {
              //  $html_status .= '<button type="button" class="btn btn-default badge-etapa" data-container="body"  data-toggle="tooltip" data-placement="top" title="'. lang('funcoes_aguardando_agendamento_etapa',1) .'"  onclick="abrir_modal_ativ_mentorias(' . $user_id . ",'" . html_entity_decode($mentoria['nome']) . "'" . ')">' . $i . '</button>';
            }
            }else{
            $html_status.="";
        }
    }else{
      //  $html_status.='<button type="button" class="btn btn-primary badge-etapa" style="background-color:'.$GLOBALS['status_color']['aguardando_confirmacao'].';border: '.$GLOBALS['status_color']['aguardando_confirmacao'].' 1px solid;" data-container="body" data-toggle="popover"  data-placement="top" data-content="Etapa marcada" >'.$i.'</button>';
    }
    return $html_status;
}

function etapasMentoriaDatas($mentorado_id,$mentor_id, $mentoria){
    $html_status="";
    if($mentoria['tipo']==0){

        $query="SELECT id,status, realizada, realizada_emp,inicio FROM cvsatividades 
    where  mentoria_id=".$mentoria['id']." and (status=3 || status=1 || status=0) and 
    mentorado_id=".$mentorado_id." and mentor_id=".$mentor_id. "  ORDER BY fim";
        $resultado_realizada=bd_query($query, $_SESSION['conexao'], 0);

        $query="SELECT id,status, realizada, realizada_emp FROM cvsatividades where  mentoria_id=".$mentoria['id']." and status=0 and mentorado_id=".$mentorado_id." and mentor_id=".$mentor_id." ORDER BY inicio LIMIT 0,1";
        $resultado_andamento=bd_query($query,  $_SESSION['conexao'], 0);


    }else if($mentoria['tipo']==1){

        $query="SELECT id,status, realizada, realizada_emp,inicio FROM cvsatividades 
    where  mentoria_id=".$mentoria['id']." and (status=3 || status=1 || status=0) and 
    mentorado_id=0 and mentor_id=".$mentor_id. " and atividade_tipo=1 ORDER BY fim";
        $resultado_realizada=bd_query($query, $_SESSION['conexao'], 0);

        $query="SELECT id,status, realizada, realizada_emp FROM cvsatividades where  mentoria_id=".$mentoria['id']." and status=0 and mentorado_id=0 and mentor_id=".$mentor_id. " and atividade_tipo=1 ORDER BY inicio LIMIT 0,1";
        $resultado_andamento=bd_query($query,  $_SESSION['conexao'], 0);


    }

    $i=0;

    while ($ativ = bd_fetch_assoc($resultado_realizada)) {
        $i++;

        $html_status.=''.$i.'º Encontro: '.cvtdatacompleta($ativ['inicio']).".</br> ";

    }
    if($i==0){
        $html_status="Nenhum sessão agendada.";
    }
    $i++;


    return $html_status;
}

function getEtapaMentoriaHtml($mentorado_id,$mentor_id, $mentoria_id){
    $html_status="";


    $query="SELECT id,status FROM cvsatividades where  mentoria_id=".$mentoria_id." and (status=3 || status=1 || status=0) and mentorado_id=".$mentorado_id." and mentor_id=".$mentor_id. "  ORDER BY fim";
    $resultado_realizada=bd_query($query, $_SESSION['conexao'], 0);

    //$query="SELECT id,status FROM cvsatividades where  mentoria_id=".$mentoria_id." and status=0 and mentorado_id=".$mentorado_id." and mentor_id=".$mentor_id." ORDER BY inicio LIMIT 0,1";
    //$resultado_andamento=bd_query($query,  $_SESSION['conexao'], 0);
    $i=0;
    //$html_status='<button type="button" class="btn btn-default badge-etapa" data-container="body"  data-toggle="tooltip" data-placement="top" title="'. lang('funcoes_aguardando_agendamento_etapa',1) .'"  >1</button>';

    while ($ativ = bd_fetch_assoc($resultado_realizada)) {
        $i++;

        if($ativ['status']==3){
            $html_status='<button type="button"  class="btn btn-primary badge-etapa"  style="background-color:'.$GLOBALS['status_color']['realizada'].';border: '.$GLOBALS['status_color']['realizada'].' 1px solid;" data-toggle="tooltip" data-placement="top" title="'. lang('funcoes_realizada',1) .'">'.$i.'</button>';
        }else if($ativ['status']==1){
            $html_status='<button type="button"  class="btn btn-primary badge-etapa"  style="background-color:'.$GLOBALS['status_color']['agendada'].';border: '.$GLOBALS['status_color']['agendada'].' 1px solid;"  data-toggle="tooltip" data-placement="top" title="'. lang('funcoes_agendada',1) .'">'.$i.'</button>';
        }else if($ativ['status']==0){
            $html_status='<button type="button"  class="btn btn-primary badge-etapa"  style="background-color:'.$GLOBALS['status_color']['aguardando_confirmacao'].';border: '.$GLOBALS['status_color']['aguardando_confirmacao'].' 1px solid;"  data-toggle="tooltip" data-placement="top" title="Aguardando Confirmação">'.$i.'</button>';
        }

    }
    $i++;

    return $html_status;
}

function etapaMentoria($mentorado_id,$mentor_id, $mentoria){
    $html_status="";

    $query="SELECT id,status,fim FROM cvsatividades where mentoria_id=".$mentoria['mentoria_id']." and (status=3 || status=1 || status=0) and mentorado_id=".$mentorado_id." and mentor_id=".$mentor_id." ORDER BY fim";
    $resultado_realizada=bd_query($query,  $_SESSION['conexao'],0);
    $i=0;
    $posicao=1;
    $status="btn-primary";

    while ($ativ = bd_fetch_assoc($resultado_realizada)) {
        $i++;

        if($ativ['id']==$mentoria['id']){
            $posicao=$i;
            if($ativ['status']==0){
                $status="btn-primary";
                $style="background-color:".$GLOBALS['status_color']['aguardando_confirmacaoama'].";border: ".$GLOBALS['status_color']['aguardando_confirmacaoama']." 1px solid;";
                $tool='data-toggle="tooltip" data-placement="top" title="'.lang('sessao_aguardando_confirmacao',1).'"';
            }else if($ativ['status']==1){
                $status="btn-success";
                $style="background-color:".$GLOBALS['status_color']['agendada'].";border: ".$GLOBALS['status_color']['agendada']." 1px solid;";
                $tool='data-toggle="tooltip" data-placement="top" title="'.lang('sessao_agendada',1).'"';
            }else if($ativ['status']==3){
                $status="btn-success";
                $style="";
                $tool='data-toggle="tooltip" data-placement="top" title="'.lang('sessao_realizada',1).'"';
            }
        }
    }

    $response=array();
    $response['html']='<button type="button" class="btn '.$status.' badge-etapa" '.$tool.' style="'.$style.'" >'.$posicao.'</button>';
    $response['etapa']=$posicao;
    return $response;
}

function getEtapaMentoria($mentoria){
    if($mentoria['tipo']==0){
        $html_status="";
        $query="SELECT count(id) as qtd FROM cvsatividades 
    where mentoria_id=".$mentoria['id']." and (status=3 or (status=1 and (realizada_emp=1 or realizada=1))) and mentorado_id=".$mentoria['solicitante_id']." and mentor_id=".$mentoria['mentor_id']."";
        $res=bd_fetch_assoc(bd_query($query,  $_SESSION['conexao'], 0));
    }else if($mentoria['tipo']==1){

        $html_status="";
        $query="SELECT count(id) as qtd FROM cvsatividades 
    where atividade_tipo=1 and mentoria_id=".$mentoria['id']." and (status=3 or (status=1 and (realizada_emp=1 or realizada=1))) and mentor_id=".$mentoria['mentor_id']."";
        $res=bd_fetch_assoc(bd_query($query,  $_SESSION['conexao'], 0));
    }

    return $res['qtd'];
}

function etapasMentoriaUltimo($mentorado_id,$mentor_id){


    $html_status="";
    $query="SELECT id,status FROM cvsatividades where (status=3 || status=1) and mentorado_id=".$mentorado_id." and mentor_id=".$mentor_id;
    $resultado_realizada=bd_query($query, $_SESSION['conexao'], 0);

    $query="SELECT id,status FROM cvsatividades where status=0 and mentorado_id=".$mentorado_id." and mentor_id=".$mentor_id." ORDER BY inicio LIMIT 0,1";
    $resultado_andamento=bd_query($query, $_SESSION['conexao'], 0);
    $i=0;

    while ($ativ = bd_fetch_assoc($resultado_realizada)) {

        $i++;
        $html_status.='<button type="button" class="btn btn-success badge-etapa"  >'.$i.'</button>';
    }

    $i++;
    if(bd_num_rows($resultado_andamento)==0){
        if($mentoria['status']==1){
            if ($mentoria['finalizado_mentor'] == '0' && $mentoria['finalizado_solicitante'] == '0') {
        $html_status='<button type="button" class="btn btn-default badge-etapa" data-container="body" data-toggle="popover" data-placement="top" data-content="'. lang('funcoes_aguardando_agendamento_etapa',1) .'" >'.$i.'</button>';
            }
        }else{
            $html_status="-";
        }


    }else{
        $html_status='<button type="button" class="btn btn-primary badge-etapa" data-container="body" data-toggle="popover"  data-placement="top" data-content="'. lang('funcoes_etapa_marcada',1). '" >'.$i.'</button>';
    }
    $response=array();
    $response['html']=$html_status;
    $response['etapa']=$i;
    return $response;
}

function get_mentoria_mentor_mentorado($mentor_mentorado_id){
    $query = "SELECT * FROM cvsmentoria as m WHERE m.status=1 and ((m.mentor_id = $mentor_mentorado_id AND m.solicitante_id = ".$_SESSION['usuario']['id'].") OR (m.solicitante_id = $mentor_mentorado_id AND m.mentor_id = ".$_SESSION['usuario']['id']."))";
    $mentoria = bd_fetch_assoc(bd_query($query, $_SESSION['conexao'], 0));
    if($mentoria){
        if($mentoria['mentor_id']==$_SESSION['usuario']['id']){
            $mentoria['mentor']=true;
        }else{
            $mentoria['mentor']=false;
        }
        return $mentoria;
    }else{
        return false;
    }
}

function finaliza_todas_atividades_admin($id){


    $query = "UPDATE atividades SET atv_status=2 
    WHERE atv_status=0 and atv_tipo=1 and atv_atribuida_para=" . $id;
    $resultado =bd_query($query, $_SESSION['conexao'], 0);

    $query="SELECT * FROM cvsatividades 
    WHERE  inicio < '".dataHoraAtual()."' and status=1 and mentoria_id=".$id;
    $result=bd_query($query, $_SESSION['conexao'], 0);
    while ($dado = bd_fetch_array_assoc($result)) {
      $query = "UPDATE cvsatividades SET 
       sessao_finalizado_por=1, status=3, sessao_finalizado_em=NOW() WHERE id=".$dado['id'];
      $resultado = bd_query($query, $_SESSION['conexao'], 0);
    }

    $query="SELECT * FROM cvsatividades 
   WHERE  ((status=1 and inicio > '".dataHoraAtual()."') or status=0) and mentoria_id=".$id;
    $result=bd_query($query, $_SESSION['conexao'], 0);

    while ($dado = bd_fetch_array_assoc($result)) {
        $query = "UPDATE cvsatividades 
        SET sessao_finalizado_por=1, sessao_finalizado_em=NOW(), status=4, motivo_cancelamento_id=1, motivo_cancelamento='Sistema' 
       WHERE id=".$dado['id'];
        $resultado = bd_query($query, $_SESSION['conexao'], 0);

    }

    return 1;
}

function finaliza_todas_atividades($id){


    $query = "UPDATE atividades SET atv_status=2 WHERE atv_status=0 and atv_tipo=1 and atv_atribuida_para=" . $id;
    $resultado =bd_query($query, $_SESSION['conexao'], 0);



    $query="SELECT * FROM cvsatividades 
    WHERE  inicio < '".dataHoraAtual()."' and status=1 and mentoria_id=".$id;
    $result=bd_query($query, $_SESSION['conexao'], 0);
    while ($dado = bd_fetch_array_assoc($result)) {
        $query = "UPDATE cvsatividades SET 
       sessao_finalizado_por=1, status=3, sessao_finalizado_em=NOW() WHERE id=".$dado['id'];
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
    }

    $query="SELECT * FROM cvsatividades 
   WHERE  ((status=1 and inicio > '".dataHoraAtual()."') or status=0) and mentoria_id=".$id;
    $result=bd_query($query, $_SESSION['conexao'], 0);

    while ($dado = bd_fetch_array_assoc($result)) {
        $query = "UPDATE cvsatividades 
        SET sessao_finalizado_por=0, sessao_finalizado_em=NOW(), status=4, motivo_cancelamento_id=1, motivo_cancelamento='Sistema' 
       WHERE id=".$dado['id'];
        $resultado = bd_query($query, $_SESSION['conexao'], 0);


    }

    return 1;



}

function get_numero_atividades_realizadas($mentoria_id,$usuario_id){
    $query="SELECT count(id) as qtd FROM cvsatividades where  mentoria_id=".$mentoria_id." and (status=3) and (mentorado_id=".$usuario_id." or mentor_id=".$usuario_id. ")  ORDER BY fim";
    $resultado_realizada=bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
    return $resultado_realizada['qtd'];
}

function resume_nome($nome){
    $split_name = explode(" ",$nome);
    $intNome=count ($split_name);
    if(count($split_name) > 2){
        for($i=1;(count($split_name) - 1) > $i; $i++){
            if(strlen($split_name[$i]) > 3){
                $split_name[$i] = substr($split_name[$i],0,1).".";
            }
        }
    }
    $nome=implode(" ",$split_name);
    return substr($nome,0, 34);
}

function salvar_files($arquivo,$caminho, $caminho_bd,$origem_tipo,$origem_id,$usr_id,$file_maximo,$file_minimo, $flag_nome, $legenda = '', $principal = 0){
    $file= $arquivo['files'];
    $resposta['error'] = false;
    $resposta['msg'] = "";
    $file_error = $file['error'];
    $file_tmp_name = $file['tmp_name'];
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_type = $file['type'];
    $extensao = strtolower(strrchr($file_name, '.'));

    if(!verificar_tipo_arquivo($file_name)){
        $resposta['msg']= "Tipo do arquivo $file_name não é permitido";
        $resposta['error']=true;
        return $resposta;
        exit;
    }


    //var_dump($arquivo);
    if ($file_maximo < $file_size) {
        $resposta['msg']= "Problema no ".$file_name." ".lang('funcoes_nao_possivel_salvar_arquivo_grande',1);
        $resposta['error']=true;

    } else if ($file_minimo > $file_size) {
        $resposta['msg']= "Problema no ".$file_name." ".lang('funcoes_nao_possivel_salvar_arquivo_pequeno',1);
        $resposta['error']=true;

    } else {

        if(!is_dir($caminho)) {
            mkdir($caminho, 0777, true);
        }
        chmod($caminho, 0777);

        $fil_nome_original=$file_name;
        if($flag_nome == 0){
            $file_name = $file_name;
        }else if($flag_nome == 1){
            $file_name = $id.$extensao;
        }else if($flag_nome == 2){
            $file_name = sha1(uniqid(rand(), true)).$extensao;
        }else if($flag_nome == 3){
            $file_name = $origem_id.$extensao;
        }else if($flag_nome == 4){
            //$file_name = sha1(uniqid(rand(), true)).$extensao;
        }else if($flag_nome == 5){
            $file_name = sha1(uniqid(rand(), true)).$origem_id.$extensao;
        }

        $sql = "INSERT INTO files(fil_caminho, fil_nome, fil_tamanho, fil_tipo, fil_status, fil_origem, fil_origem_id, criado_em, criado_por, fil_legenda, fil_principal,fil_nome_original)
                        VALUES ('$caminho_bd','$file_name','$file_size','$file_type',1,'$origem_tipo','$origem_id', '".dataHoraAtual()."','$usr_id','$legenda','$principal','$fil_nome_original')";
        $resultado = bd_query($sql, $_SESSION['conexao'], 0);

        if($resultado) {
            $id = bd_last_id();
            if (!$file_error) {
                $save_img = move_uploaded_file($file_tmp_name, $caminho .$file_name);
                if ($save_img) {
                    $resposta['msg'] = "";
                    $resposta['error'] = false;
                    $resposta['id'] = $id;
                    $resposta['file_name'] = $file_name;

                } else {
                    $resposta['msg'] = "Problema no ".$file_name." ".lang('funcoes_nao_possivel_salvar_arquivo_1',1);
                    $resposta['error'] = true;
                }
            } else {
                $resposta['msg'] = "Problema no ".$file_name." ".lang('funcoes_nao_possivel_salvar_arquivo_2',1);
                $resposta['error'] = true;
            }
        }else{
            $resposta['msg'] = "Problema no ".$file_name." ".lang('funcoes_nao_possivel_salvar_arquivo_3',1);
            $resposta['error'] = true;
        }
    }

    return $resposta;

}

function removerFiles($fil_id,$fil_origem,$fil_origem_id){
    $resposta=array();
    $sql="SELECT * FROM files WHERE fil_origem=$fil_origem and fil_origem_id=$fil_origem_id
    and fil_id =".(int)$fil_id;
    $resultado= bd_query($sql, $_SESSION['conexao'],0);
    if($resultado){
        $arquivos=bd_fetch_array_assoc($resultado);
        $sql = "DELETE FROM files WHERE fil_origem=$fil_origem and fil_origem_id=$fil_origem_id
    and fil_id =".(int)$fil_id;
        $resultado= bd_query($sql, $_SESSION['conexao'],0);
        if($resultado){
            unlink(__DIR__."/../".$arquivos['fil_caminho'].$arquivos['fil_nome']);
            $resposta['error'] = false;
            $resposta['error_msg'] = "";

        }else{
            $resposta['error_msg'] = "Ocorreu um problema deletar o arquivo";
            $resposta['error'] = true;
        }
    }else{
        $resposta['error_msg'] = "Ocorreu um problema deletar o arquivo";
        $resposta['error'] = true;
    }
    return $resposta;
}

function salvar_imagem_file($usuario_id, $arquivo,$croped_image,$origem_id)
{


    $file_path_1 = '../../'.$GLOBALS['file_path_1'];
    $file_atividades_in1 = '../../'.$GLOBALS['file_avatar_in1'];
    $file_temp1 = '../../'.$GLOBALS['file_temp1'];

    $file_name = $arquivo['name'];
    $file_type = $arquivo['type'];
    $file_size = $arquivo['size'];
    $file_tmp_name = $arquivo['tmp_name'];
    $file_error = $arquivo['error'];
    if ($arquivo == null) {
        return 1;
    } else {
        if(!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp|jpg)$/', $file_type)) {
            $resposta['msg']= "Tipo de arquivo não é permitido";
            $resposta['error']=true;
            return $resposta;
            exit;
        }



        $query = 'SELECT fil_id, fil_nome FROM files WHERE fil_origem=4 and fil_origem_id='.$origem_id;
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        $dado = bd_fetch_array($resultado);
        if ($dado['fil_id'] != 0) {
            $resultado=true;
            if ($resultado) {
                unlink($file_path_1 . $GLOBALS['file_atividades']['path']. $dado['fil_nome']);

                list($type, $croped_image) = explode(';', $croped_image);
                list(, $croped_image)      = explode(',', $croped_image);
                $croped_image = base64_decode($croped_image);

                file_put_contents($file_path_1 . $GLOBALS['file_atividades']['path'] . $dado['fil_nome'] , $croped_image);
                return 1;
            }else{
                return '<h3 class="text-danger">'. lang('funcoes_nao_possivel_enviar_imagem') .'</h3>';
            }


        } else {
            $file_salt = base64_encode(rand_bytes(8, true));
            $nome_final = sha1($file_name . $file_salt);

            $sql = "INSERT INTO files(fil_caminho, fil_nome, fil_tamanho, fil_tipo, fil_status, fil_origem, fil_origem_id, criado_em, criado_por, fil_legenda, fil_principal)
                        VALUES ('".$GLOBALS['file_atividades']['path']."','$nome_final','$file_size','$file_type',1,4,'$origem_id', '".dataHoraAtual()."','$usuario_id','','')";
            $resultado = bd_query($sql, $_SESSION['conexao'], 0);

            if ($resultado) {

                list($type, $croped_image) = explode(';', $croped_image);
                list(, $croped_image)      = explode(',', $croped_image);
                $croped_image = base64_decode($croped_image);

                file_put_contents($file_path_1 . $GLOBALS['file_atividades']['path']. $nome_final, $croped_image);

                return 1;
            } else {
                return '<h3 class="text-danger">'. lang('funcoes_nao_possivel_enviar_foto') .'</h3>';
            }
        }
    }
}

function getFeedsMural()
{
    $date = date('Y-m-d');
    if($_SESSION['usuario']['regra_id']==1){
        $where='(atv_atribuida_para=0 or atv_atribuida_para=1) ';
        $pilares_sol = sanitize_array(busca_user_pilares_sol($_SESSION['usuario']['id']));
    }else{
        if($_SESSION['usuario']['conexao']==2){
            $where='(atv_atribuida_para=0 or atv_atribuida_para=2) ';
        }else{
            $where='(atv_atribuida_para=0 or atv_atribuida_para=1 or atv_atribuida_para=2) ';
            $pilares_sol = sanitize_array(busca_user_pilares_sol($_SESSION['usuario']['id']));
        }
        $pilares = sanitize_array(busca_user_pilares($_SESSION['usuario']['id']));

    }


    $where_pilar="(0";

    if(is_array($pilares_sol)) {
        if (count($pilares_sol) > 0) {
            $where_pilar .= ',';
            foreach ($pilares_sol as $pilar) {
                $where_pilar .= $pilar['pilar_id'] . ',';
            }
            $where_pilar = substr($where_pilar, 0, -1);
        }
    }
    if(is_array($pilares)) {
        if (count($pilares) > 0) {
            $where_pilar .= ',';
            foreach ($pilares as $pilar) {
                $where_pilar .= $pilar['pilar_id'] . ',';
            }
            $where_pilar = substr($where_pilar, 0, -1);
        }
    }

    $where_pilar.=")";
    $sql = "Select atv_id, atv_titulo,atv_titulo_eng,atv_titulo_esp,atv_descricao,atv_descricao_eng,atv_descricao_esp, 
    a.criado_em, atv_data_inicio, a.alterado_em, pilar_id, cp.cor, 
    cp.nome as pilar_nome,
    cp.nome_eng as pilar_nome_eng,
    cp.nome_esp as pilar_nome_esp, 
    fil_nome,fil_id
    FROM atividades as a 
    left join cvspilares as cp on a.pilar_id=cp.id
    LEFT JOIN files AS f ON f.fil_origem_id = a.atv_id and fil_origem=4
    WHERE a.pilar_id IN $where_pilar and  a.atv_tipo=0 and a.atv_status=1 and $where AND 
    a.atv_data_insercao < NOW() AND (a.atv_data_exclusao = '0000-00-00 00:00:00' || a.atv_data_exclusao > '".dataHoraAtual()."')
    ORDER BY a.criado_em DESC, atv_id DESC";
    $resultado = bd_query($sql, $_SESSION['conexao'], 0);

    if ($resultado) {
        $cont = bd_num_rows($resultado);

        $objs = array();
        if ($cont > 0) {
            while ($obj = bd_fetch_array_assoc($resultado)) {
                if($obj['fil_nome']!=''){
                    //$obj['url_img'] = FILE_ATIVIDADES . $obj['fil_nome'] . '?' . date('His');
                    $obj['url_img'] ="imagem?id=".$obj['fil_id'];
                }else{
                    $obj['url_img'] = PATH_ASSETS_IMG."placeholder.png";
                }
                $objs[] = $obj;
            }
        }
        $resposta['feeds'] = $objs;
        $resposta['error'] = "";
    } else {
        $resposta['error'] = lang('funcoes_erro_buscar_dados',1);
    }

    return $resposta;
}

function getFeedsMuralAll($pilares_sol)
{
    $date = date('Y-m-d');

    if(count($pilares_sol)>0){
        $where=' a.pilar_id in (';
        foreach ($pilares_sol as $pilar){
            $where.=seguro($pilar).',';
        }
        $where= substr($where, 0, -1);
        $where= $where.") and ";
    }


    if($_SESSION['usuario']['regra_id']==1){
        $where2='(atv_atribuida_para=0 or atv_atribuida_para=1) ';
        $pilares_sol = sanitize_array(busca_user_pilares_sol( $_SESSION['usuario']['id']));
    }else{
        if($_SESSION['usuario']['conexao']==2){
            $where2='(atv_atribuida_para=0  or atv_atribuida_para=2) ';
        }else{
            $where2='(atv_atribuida_para=0 or atv_atribuida_para=1 or atv_atribuida_para=2) ';
            $pilares_sol = sanitize_array(busca_user_pilares_sol( $_SESSION['usuario']['id']));
        }
        $pilares = sanitize_array(busca_user_pilares( $_SESSION['usuario']['id']));
    }


    $where_pilar="(0";
    if(is_array($pilares_sol)){
    if(count($pilares_sol)>0){
        $where_pilar.=',';
        foreach ($pilares_sol as $pilar){
            $where_pilar.=$pilar['pilar_id'].',';
        }
        $where_pilar= substr($where_pilar, 0, -1);
    }
    }
    if(is_array($pilares)) {
        if (count($pilares) > 0) {
            $where_pilar .= ',';
            foreach ($pilares as $pilar) {
                $where_pilar .= $pilar['pilar_id'] . ',';
            }
            $where_pilar = substr($where_pilar, 0, -1);
        }
    }
    $where_pilar.=")";


    $sql = "Select atv_id, atv_titulo,atv_titulo_eng,atv_titulo_esp,
    atv_descricao,atv_descricao_eng,atv_descricao_esp, 
    a.criado_em, atv_data_inicio, a.alterado_em, pilar_id, cp.cor, 
    cp.nome as pilar_nome,
    cp.nome_eng as pilar_nome_eng,
    cp.nome_esp as pilar_nome_esp, 
    f.fil_nome,f.fil_id 
    FROM atividades as a 
    LEFT JOIN cvspilares as cp on a.pilar_id=cp.id
    LEFT JOIN files AS f ON f.fil_origem_id = a.atv_id and fil_origem=4
    WHERE a.pilar_id IN $where_pilar and atv_tipo=0 and a.atv_id<>-1 and $where a.atv_status=1 and $where2 AND
    a.atv_data_insercao < NOW() AND (a.atv_data_exclusao = '0000-00-00 00:00:00' || a.atv_data_exclusao > '".dataHoraAtual()."')
    ORDER BY a.criado_em DESC, atv_id DESC";
    $resultado = bd_query($sql, $_SESSION['conexao'],0);

    if ($resultado) {
        $cont = bd_num_rows($resultado);

        $objs = array();
        if ($cont > 0) {
            while ($obj = bd_fetch_array_assoc($resultado)) {

                if($obj['fil_nome']!=''){
                    $obj['url_img'] ="imagem?id=".$obj['fil_id'];
                }else{
                    $obj['url_img'] = PATH_ASSETS_IMG."placeholder.png";
                }
                $objs[] = $obj;
            }
        }
        $resposta['feeds'] = $objs;
        $resposta['error'] = "";
    } else {
        $resposta['error'] = lang('funcoes_erro_buscar_dados',1);
    }

    return $resposta;
}

function exportarAtividade($atv_id, $usuario_id){

   require_once(__DIR__."/../extensoes/icalendar/zapcallib.php");

    $data = $_POST['data'];

    if(!is_int((int)$atv_id)){
        lang('funcoes_ops_sem_permissao',1);
    }


    $query = "SELECT 
                 a.id AS id, 
                 a.solicitante_id AS solicitante_id, 
                 a.solicitado_id AS solicitado_id, 
                 a.atividade_tipo_id AS atividade_tipo_id, 
                 a.obs AS obs,  
                  a.obs_mentor AS obs_mentor, 
                 a.inicio AS inicio, 
                 a.fim AS fim, 
                 t.nome AS nome, 
                 t.nome_eng AS nome_eng, 
                 t.nome_esp AS nome_esp, 
                 u.nome AS solicitado_nome,
                 a.atividade AS atividade, 
                 a.descricao AS descricao,
                 a.mentor_id AS mentor_id,
                 a.mentorado_id AS mentorado_id,
                 a.link_atividade
             FROM cvsatividades AS a
             LEFT JOIN cvsatividades_tipo AS t ON a.atividade_tipo_id = t.id
             JOIN cvsusuario_usuarios AS u ON u.id = a.solicitado_id
             WHERE a.id = " . (int)$atv_id . " AND (a.solicitante_id = $usuario_id OR solicitado_id = $usuario_id)";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);

    if (bd_num_rows($resultado) > 0) {
        $dado = bd_fetch_array($resultado);


        if($dado['mentorado_id']==$usuario_id){
            $nome = busca_usuario( $dado['mentor_id'])['nome'];
        }else{
            $nome = busca_usuario( $dado['mentorado_id'])['nome'];
        }

        $organizador = busca_usuario( $dado['solicitante_id']);
        $solicitado = busca_usuario( $dado['solicitado_id']);

        $title = lang('admin_sessao_mentoria_minusc',1);
        $event_start =$dado['inicio'];
        $event_end =   $dado['fim'];
        $uid = $dado['id'].NOME_PROJETO_CALENDAR."@mentorar.com.br";

        $icalobj = new ZCiCal();
        $eventobj = new ZCiCalNode("VEVENT", $icalobj->curnode);
        $eventobj->addNode(new ZCiCalDataNode("SUMMARY:" . $title));
        $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($event_start)));
        $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_end)));
        $eventobj->addNode(new ZCiCalDataNode( 'ORGANIZER;CN="'.$organizador['nome'].'":mailto:'.$organizador['email'].''));
        $eventobj->addNode(new ZCiCalDataNode( 'ATTENDEE;CN="'.$solicitado['nome'].'";RSVP=TRUE:mailto:'.$solicitado['email'].''));
        $eventobj->addNode(new ZCiCalDataNode('LOCATION;LANGUAGE=pt-BR:'.NOME_PROJETO_CALENDAR));
        $eventobj->addNode(new ZCiCalDataNode("UID:" . $uid));
        $eventobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime()));
        $mensagem=lang('sistema_sessao_mentoria',1).$nome.'<br><br>';
        if($dado['link_atividade']!=''){
            $mensagem=$mensagem."Link: ".$dado['link_atividade']."<br><br>";
        }
        if($dado['obs']!=''){
            $mensagem=$mensagem.$dado['obs']."<br><br>";
        }
        if($dado['link_atividade']==''){
            $mensagem=$mensagem."Link do chat na plataforma: ".LINK_CHAT."?sala=".SALA_CHAT.$dado['atv_id']."&nome=".$_SESSION['usuario']['nome']."<br><br>";
        }
       $eventobj->addNode(new ZCiCalDataNode("Description:" . ZCiCal::formatContent($mensagem)));

        header("Content-type:text/calendar");
        header('Content-Disposition: attachment; filename="' . 'calendario-sessao-'.$atv_id . '.ics"');
        Header('Content-Length: ' . $icalobj->export());
        Header('Connection: close');
        echo $icalobj->export();

    } else {
        lang('funcoes_ops_sem_permissao',1);
        die();
    }


}

function exportarAtividadeEmail($atv_id, $usuario_id){

    require_once(__DIR__."/../extensoes/icalendar/zapcallib.php");

    $data = $_POST['data'];

    if(!is_int((int)$atv_id)){
        $resposta['error']=lang('funcoes_ops_sem_permissao',1);
    }
    $query = "SELECT 
                 a.id AS id, 
                 a.solicitante_id AS solicitante_id, 
                 a.solicitado_id AS solicitado_id, 
                 a.atividade_tipo_id AS atividade_tipo_id, 
                 a.obs AS obs,  
                 a.obs_mentor AS obs_mentor, 
                 a.inicio AS inicio, 
                 a.fim AS fim, 
                 t.nome AS nome, 
                 t.nome_eng AS nome_eng, 
                 t.nome_esp AS nome_esp, 
                 u.nome AS solicitado_nome,
                 a.atividade AS atividade, 
                 a.descricao AS descricao,
                 a.mentor_id AS mentor_id,
                 a.mentorado_id AS mentorado_id,
                 a.link_atividade
             FROM cvsatividades AS a
             LEFT JOIN cvsatividades_tipo AS t ON a.atividade_tipo_id = t.id
             JOIN cvsusuario_usuarios AS u ON u.id = a.solicitado_id
             WHERE a.id = " . (int)$atv_id . " AND (a.solicitante_id = $usuario_id OR solicitado_id = $usuario_id)";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);

    if (bd_num_rows($resultado) > 0) {
        $dado = bd_fetch_array($resultado);


        if($dado['mentorado_id']==$usuario_id){
            $usuario = busca_usuario( $dado['mentor_id']);
        }else{
            $usuario = busca_usuario( $dado['mentorado_id']);
        }
        $organizador = busca_usuario($dado['solicitante_id']);
        $solicitado = busca_usuario($dado['solicitado_id']);

        $nome=$usuario['nome'];
        $idioma=$_SESSION['usuario']['idioma'];
        $title = lang('admin_sessao_mentoria_minusc',1);
        $data_sessao = cvtdatacompletaformatada($dado['inicio']);
        $event_start =$dado['inicio'];
        $event_end =   $dado['fim'];

        $uid = $dado['id'].NOME_PROJETO_CALENDAR."@mentorar.com.br";

        $icalobj = new ZCiCal();
        $eventobj = new ZCiCalNode("VEVENT", $icalobj->curnode);
        $eventobj->addNode(new ZCiCalDataNode( 'ORGANIZER;CN="'.$organizador['nome'].'":mailto:'.$organizador['email'].''));
        $eventobj->addNode(new ZCiCalDataNode( 'ATTENDEE;CN="'.$solicitado['nome'].'";RSVP=TRUE:mailto:'.$solicitado['email'].''));
        $eventobj->addNode(new ZCiCalDataNode('LOCATION;LANGUAGE=pt-BR:'.NOME_PROJETO_CALENDAR));

        $eventobj->addNode(new ZCiCalDataNode("SUMMARY:" . $title));
        $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($event_start)));
        $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_end)));

        $eventobj->addNode(new ZCiCalDataNode("UID:" . $uid));
        $eventobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime()));



        $mensagem=lang('sistema_sessao_mentoria',1).$nome.'<br><br>';
        if($dado['link_atividade']!=''){
            $mensagem=$mensagem."Link: ".$dado['link_atividade']."<br><br>";
        }
        if($dado['obs']!=''){
            $mensagem=$mensagem.$dado['obs']."<br><br>";
        }

        if($dado['link_atividade']==''){
            $mensagem=$mensagem."Link do chat na plataforma: ".LINK_CHAT."?sala=".SALA_CHAT.$dado['atv_id']."&nome=".$_SESSION['usuario']['nome']."<br><br>";
        }

        $eventobj->addNode(new ZCiCalDataNode("Description:" . ZCiCal::formatContent($mensagem)));




        if($idioma==0){
            $assunto=$_SESSION['parametros']['projeto_nome'];
            $titulo='A data e hora da sessão';
            $mensagem='<p>Olá '.$nome.', </p>
            <p>Sua sessão de mentoria com <b>'. $usuario['nome'] .'</b> no dia <b>'. $data_sessao .'</b>, 
        para mais detalhes acesse o Programa de Mentoria clicando no botão abaixo.</p>';
            $botao='ACESSAR';
        }else if($idioma==1) {
            $assunto = $_SESSION['parametros']['projeto_nome'];
            $titulo='The date and time of the session';
            $mensagem='<p>Hello '.$nome.',</p>
            <p>Your mentoring session with the <b>'. $usuario['nome'] .'</b> in day <b>'. $data_sessao .'</b>, 
        for more details access the Mentoring Program by clicking on the button below. </p>';
            $botao='ACCESS';
        }else if($idioma==2) {
            $assunto = $_SESSION['parametros']['projeto_nome'];
            $titulo='Hora de la sesión';
            $mensagem='<p>Hola '.$nome.',</p>
            <p>Su sesión de tutoría con el <b>'. $usuario['nome'] .'</b> en el día <b>'. $data_sessao .'</b>, 
            para más detalles acceda al Programa de Mentores haciendo clic en el botón de abajo. </p>';
            $botao='ACCESO';
        }
        $corpo    = createMail($idioma, array(
            'title'       => $assunto,
            'content'     => $mensagem,
            'action'      => $botao,
            'action-link' => URL,
        ));

       $resultado= enviar_email($assunto, $corpo, $_SESSION['usuario']['email'], null, null,'','', '', $icalobj->export());
       if($resultado){
           $resposta['error']="";
       }else{
           $resposta['error']= "Não foi possível enviar o e-mail!";
       }

    } else {
        $resposta['error']= lang('funcoes_ops_sem_permissao',1);
    }

    return $resposta;
}

function exportarAtividadeMentoria($mentoria_id, $usuario_id){

    require_once(__DIR__."/../extensoes/icalendar/zapcallib.php");

    $data = $_POST['data'];

    if(!is_int((int)$atv_id)){
        lang('funcoes_ops_sem_permissao',1);
    }
    $query = "SELECT 
                 a.id AS id, 
                 a.solicitante_id AS solicitante_id, 
                 a.solicitado_id AS solicitado_id, 
                 a.atividade_tipo_id AS atividade_tipo_id, 
                 a.obs AS obs,  
                 a.inicio AS inicio, 
                 a.fim AS fim, 
                 t.nome AS nome, 
                 t.nome_eng AS nome_eng, 
                 t.nome_esp AS nome_esp, 
                 u.nome AS solicitado_nome,
                 a.atividade AS atividade, 
                 a.descricao AS descricao,
                 a.mentor_id AS mentor_id,
                 a.mentorado_id AS mentorado_id,
                 link_atividade
             FROM cvsatividades AS a
             LEFT JOIN cvsatividades_tipo AS t ON a.atividade_tipo_id = t.id
             JOIN cvsusuario_usuarios AS u ON u.id = a.solicitado_id
             WHERE a.mentoria_id = " .(int)$mentoria_id." AND a.status in (0,1) AND (a.solicitante_id = $usuario_id OR solicitado_id = $usuario_id)";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);

    if (bd_num_rows($resultado) > 0) {
        $icalobj = new ZCiCal();


        while($dado = bd_fetch_array($resultado)) {

            if ($dado['mentorado_id'] == $usuario_id) {
                $nome = busca_usuario( $dado['mentor_id'])['nome'];
            } else {
                $nome = busca_usuario( $dado['mentorado_id'])['nome'];
            }

            $organizador = busca_usuario( $dado['solicitante_id']);
            $solicitado = busca_usuario( $dado['solicitado_id']);

            $title = lang('admin_sessao_mentoria_minusc',1);
            $event_start = $dado['inicio'];
            $event_end = $dado['fim'];
            $uid = $dado['id'].NOME_PROJETO_CALENDAR."@mentorar.com.br";


            $eventobj = new ZCiCalNode("VEVENT", $icalobj->curnode);
            $eventobj->addNode(new ZCiCalDataNode("SUMMARY:" . $title));
            $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($event_start)));
            $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_end)));
            $eventobj->addNode(new ZCiCalDataNode( 'ORGANIZER;CN="'.$organizador['nome'].'":mailto:'.$organizador['email'].''));
            $eventobj->addNode(new ZCiCalDataNode( 'ATTENDEE;CN="'.$solicitado['nome'].'";RSVP=TRUE:mailto:'.$solicitado['email'].''));
            $eventobj->addNode(new ZCiCalDataNode('LOCATION;LANGUAGE=pt-BR:'.NOME_PROJETO_CALENDAR));
            $eventobj->addNode(new ZCiCalDataNode("UID:" . $uid));
            $eventobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime()));

            $mensagem=lang('sistema_sessao_mentoria',1).$nome.'<br><br>';
            if($dado['link_atividade']!=''){
                $mensagem=$mensagem."Link: ".$dado['link_atividade']."<br><br>";
            }
            if($dado['obs']!=''){
                $mensagem=$mensagem.$dado['obs']."<br><br>";
            }

            if($dado['link_atividade']==''){
                $mensagem=$mensagem."Link do chat na plataforma: ".LINK_CHAT."?sala=".SALA_CHAT.$dado['atv_id']."&nome=".$_SESSION['usuario']['nome']."<br><br>";
            }

            $eventobj->addNode(new ZCiCalDataNode("Description:" . ZCiCal::formatContent($mensagem)));

        }



        header("Content-type:text/calendar");
        header('Content-Disposition: attachment; filename="' . 'mentoria-'.$mentoria_id . '.ics"');
        Header('Content-Length: ' . $icalobj->export());
        Header('Connection: close');
        echo $icalobj->export();

    } else {
        lang('funcoes_ops_sem_permissao',1);
    }


}

function statusToTag($mentoria, $status_color, $status_text){
    $hoje = date("Y-m-d H:i:s");
    if (strtotime($hoje) > strtotime($mentoria['inicio']) && strtotime($hoje) < strtotime($mentoria['fim'])
        && $mentoria['status'] == 1) {
        return ('<span class="label" style="background-color:' . $status_color['andamento'] . ';color: white">' . $status_text['andamento'] . '</span>');
    } else if (strtotime($hoje) > strtotime($mentoria['fim'])) {//se ja acabou{
        if ($mentoria['realizada'] == 0 && $mentoria['status'] == 1) {
            return ('<span class="label" style="color:black;background-color:' . $status_color['aguardando_avaliacao'] . ';color: white">' . $status_text['aguardando_avaliacao'] . '</span>');
        }
        if ($mentoria['realizada'] == 0 && $mentoria['status'] == 0) {
            return ('<span class="label" style="background-color:' . $status_color['rejeitada'] . '; color: white">' . $status_text['rejeitada'] . '</span>');
        } else if ($mentoria['realizada'] == 2) {
            return ('<span class="label" style="background-color:' . $status_color['nao_realizada'] . ';color: white">' . $status_text['nao_realizada'] . '</span>');
        } else if ($mentoria['status'] == 3) {
            return ('<span class="label" style="background-color:' . $status_color['realizada'] . ';color: white">' . $status_text['realizada'] . '</span>');
        } else if ($mentoria['status'] == 2) {
            return ('<span class="label" style="background-color:' . $status_color['rejeitada'] . ';color: white">' . $status_text['rejeitada'] . '</span>');
        }else if ($mentoria['status'] == 1 && $mentoria['realizada'] == 1) {
            return ('<span class="label" style="background-color:' . $status_color['aguardando_avaliacao'] . ';color: white">' . $status_text['aguardando_avaliacao'] . '</span>');
        }
        else if ($mentoria['status'] == 4) {
            return ('<span class="label" style="background-color:' . $status_color['cancelada'] . ';color: white">' . $status_text['cancelada'] . '</span>');
        }

    } else if ($mentoria['status'] == 0) {
        return ('<span class="label" style="color:black;background-color:' . $status_color['aguardando_confirmacao'] . ';color: white">' . $status_text['aguardando_confirmacao'] . '</span>');
    } else if ($mentoria['status'] == 1) {
        return ('<span class="label" style="background-color:' . $status_color['agendada'] . ';color: white">' . $status_text['agendada'] . '</span>');
    } else if ($mentoria['status'] == 2) {
        return ('<span class="label" style="background-color:' . $status_color['rejeitada'] . ';color: white">' . $status_text['rejeitada'] . '</span>');
    } else if ($mentoria['status'] == 4) {
        return ('<span class="label" style="background-color:' . $status_color['cancelada'] . ';color: white">' . $status_text['cancelada'] . '</span>');
    }else if ($mentoria['status'] == 5) {
        return ('<span class="label" style="background-color:' . $status_color['cancelada'] . ';color: white">' . $status_text['nao_realizada'] . '</span>');
    }
}

function conexaoStatusToTag($status)
{
    $str_tag = "";
    if($status == 2){
        $str_tag = "<label class='label' style='background-color: #BC204B' >".lang('funcao_status_encerrada',1)."</label>";
    }else if($status == 1){
        $str_tag = "<label class='label' style='background-color: #009A58' >".lang('funcao_status_em_andamento',1)."</label>";
    }else if($status == 0){
        $str_tag = "<label class='label' style='background-color: #F68D2E' >".lang('funcao_status_solicitacao',1)."</label>";
    }else if($status == 3){
        $str_tag = "<label class='label' style='background-color: #BC204B' >".lang('funcao_status_recusada',1)."</label>";
    }

    return $str_tag;
}

function busca_pilares_usuario($user_id){
    $query="SELECT * FROM cvsusuario_pilares as cp join cvspilares as p on cp.pilar_id=p.id  WHERE cp.status=0 and cp.usuario_id=".$user_id;
    $pilares=bd_query($query, $_SESSION['conexao'],0);
    $array=array();
    while($pilar= bd_fetch_array($pilares)){
        $array[]=$pilar;

    }
    return $array;
}

function viewAvatar($avatar, $id){

    $html='';
    if ($avatar['pathnamehash']) {
        $html="<img class=\"busca_mentorias_avatar\" onclick=\"visualizar_participante( ".$id.")\" 
       src=\"".FILE_THUMB . $avatar['pathnamehash'] . ".jpeg?var=".time ()."\" width=\"200\" height=\"75\" name=\"image\" style=\"cursor: pointer\"/>";
    } else {
        $html="<img class=\"busca_mentorias_avatar\" onclick=\"visualizar_participante( ".$id.")\"
      src=\"".PATH_ASSETS_IMG."/photo.jpg\" alt=\"avatar\" style=\"cursor: pointer\">";
    }
    echo $html;

}

function add_logs($tipo, $descricao){
    $user = $_SESSION['usuario'];

    if (!$user) {
        $user_id=0;
    }else{
        $user_id=$_SESSION['usuario']['id'];
    }
    $query="INSERT INTO logs( descricao,data, usr_id, tipo) VALUES ('".seguro($descricao)."', '".dataHoraAtual()."',$user_id,'".seguro($tipo)."')";
    //bd_query($query, $_SESSION['conexao'], 0);
}


function atividadesMentoria($mentorado_id,$mentor_id, $mentoria){
    $html_status="";


    $query = "SELECT * FROM atividades WHERE atv_tipo=1 and atv_atribuida_para=".$mentoria['id'];
    $resultado_realizada=bd_query($query, $_SESSION['conexao'], 0);

    $i=0;

    while ($ativ = bd_fetch_assoc($resultado_realizada)) {
        $i++;

       if($ativ['atv_status']==1){
            $html_status.='<button type="button" onclick="visualizar_atividade_sessao('.$ativ['atv_id'].')" class="btnmodify-10 btn btn-success badge-etapa"  style="background-color:'.$GLOBALS['status_color_atividade']['entregue'].';border: '.$GLOBALS['status_color_atividade']['entregue'].' 1px solid;"  data-toggle="tooltip" data-placement="top" title="'. lang('funcoes_encerrada',1) . '">'.$i.'&nbsp;&nbsp;'.lang("status_atividade_entregue",1).'</button>';
        }else if($ativ['atv_status']==0){
            $html_status.='<button type="button" onclick="visualizar_atividade_sessao('.$ativ['atv_id'].')" class="btnmodify-9 btn btn-default badge-etapa"  style="background-color:'.$GLOBALS['status_color_atividade']['pendente'].';border: '.$GLOBALS['status_color_atividade']['pendente'].' 1px solid;    color: white;"   data-toggle="tooltip" data-placement="top" title="'. lang('funcoes_atividade_pendente',1) . '">'.$i.'&nbsp;&nbsp;'.lang("status_atividade_pendente",1).'</button>';
        }else if($ativ['atv_status']==2){
           $html_status.='<button type="button" onclick="visualizar_atividade_sessao('.$ativ['atv_id'].')" class="btnmodify-11 btn btn-default badge-etapa"  style="color:#ffffff;    background-color: #888888;border: #888888 1px solid;"  data-toggle="tooltip" data-placement="top" title="'. lang('funcoes_nao_finalizada',1) . '">'.$i.'&nbsp;&nbsp;'.lang("status_atividade_nao_entregue",1).'</button>';
       }

    }

    if($i==0){
        if($mentor_id==$_SESSION['usuario']['id']){
            if($mentoria['status']==1){
                if ($mentoria['finalizado_mentor'] == '0' && $mentoria['finalizado_solicitante'] == '0') {
                    $html_status .= '&nbsp;' . lang('funcao_nao_ha_nenhuma_atividade', 1) . '&nbsp;<a style="position: relative;    top: 2px;" onClick="cadastrar_atividade_sessao(' . $mentoria['id'] . ')" ><i class="fa fa-plus"></i> ' . lang('funcao_atividade', 1) . '</a>';
                }
                }else{
                $html_status.='&nbsp;&nbsp;'.lang('funcao_nao_ha_nenhuma_atividade',1).'';
            }
        }else{
            $html_status.='&nbsp;&nbsp;'.lang('funcao_nao_ha_nenhuma_atividade',1).'';
        }

    }else{
        if($mentor_id==$_SESSION['usuario']['id']) {
            if($mentoria['status']==1){
                if ($mentoria['finalizado_mentor'] == '0' && $mentoria['finalizado_solicitante'] == '0') {
                    $html_status .= '&nbsp;<a style="position: relative;    top: 2px;" onClick="cadastrar_atividade_sessao(' . $mentoria['id'] . ')" ><i class="fa fa-plus"></i> ' . lang('funcao_atividade', 1) . '</a>';
                }
            }else{
                $html_status .= '&nbsp;';
            }
        }
    }
    return $html_status;
}

function aceita_atividade_validacao( $data_inicio, $hora_inicio, $data_fim, $hora_fim, $mentorado_id, $tipo_atividade, $vinculo_id, $obs,$mentoria_id)
{
    $inicio = salva_data_hora($data_inicio, $hora_inicio);
    $fim = salva_data_hora($data_fim, $hora_fim);
    $query = "SELECT
 a.id as id
 FROM cvsatividades as a
 join cvsusuario_usuarios as u on u.id=a.solicitado_id
 WHERE a.inicio>='$inicio' and a.fim<='$fim' and a.status<>4 and (a.solicitante_id=" . $_SESSION['usuario']['id'] . " or solicitado_id=" . $_SESSION['usuario']['id'] . ')';
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    if (bd_num_rows($dados) > 0) {
        $data['erro'] = 2;
    }
    if ($data['erro'] == '') {
        $query = "SELECT
 a.id as id
 FROM cvsatividades as a
 join cvsusuario_usuarios as u on u.id=a.solicitado_id
 WHERE a.inicio>='$inicio' and a.fim<='$fim' and a.status<>4 and (a.solicitante_id=" . $mentorado_id . " or solicitado_id=" . $mentorado_id . ')';
        $dados = bd_query($query, $_SESSION['conexao'], 0);
        if (bd_num_rows($dados) > 0) {
            $data['erro'] = 3;
        }
    }
    if ($data['erro'] == '') {
        $query = "
INSERT INTO cvsatividades(
  solicitante_id, solicitado_id, atividade_tipo_id,
  obs_mentor, inicio, fim, solicitante_confirmacao, criado_em,solicitante_confirmacao_data,vinculo, mentor_id, mentorado_id, mentoria_id)
  VALUES ('" . $_SESSION['usuario']['id'] . "','" . $mentorado_id . "','" . $tipo_atividade . "','" . $obs . "','" . $inicio . "','" . $fim . "',1, '".dataHoraAtual()."',NOW()," . $vinculo_id . ", " . $_SESSION['usuario']['id'] . ", $mentorado_id, $mentoria_id)";
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        $atividade_id = bd_last_id($_SESSION['conexao']);
        if ($resultado) {
            insere_interacao($_SESSION['usuario']['id'], $atividade_id, 0, $mentorado_id);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }


}

function buscar_usuario($user_id){

    $query = "SELECT * FROM cvsusuario_usuarios as u
        where u.id=" . $user_id;

    $dados = bd_query($query, $_SESSION['conexao'], 0);
    return bd_fetch_assoc($dados);
}

function verificarDisponibilidadeAgenda($mentor_id){
    $existe=0;
    $query = "SELECT ua.id as id, ua.inicio as inicio,
                ua.fim as fim, ua.tipo as tipo,atividade_tipo_id,obs
             FROM cvsusuario_agenda as ua
              WHERE ua.inicio >= '" . dataHoraAtual() . "' 
              AND (tipo=2 or tipo=0)
              AND ua.usuario_id = $mentor_id order by ua.inicio asc";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    $response['horarios'] = array();
    while ($dado = bd_fetch_assoc($dados)) {
        $aux = array();
        $dado['inicio'] = date("Y-m-d H:i:s",strtotime($dado['inicio']." +1 minutes"));
        $dado['fim'] = date("Y-m-d H:i:s",strtotime($dado['fim']." -1 minutes"));
        $query = "SELECT *    
                        FROM cvsatividades 
                        WHERE ((inicio BETWEEN '" . $dado['inicio'] . "' AND '" . $dado['fim'] . "') 
                        OR (fim BETWEEN '" . $dado['inicio'] . "' AND '" . $dado['fim'] . "') OR (fim >= '" . $dado['fim'] . "' and inicio < '" . $dado['inicio'] . "')) 
                        AND status <> 4 AND status <> 2 AND (solicitante_id = $mentor_id OR solicitado_id = $mentor_id)";
        $result = bd_query($query, $_SESSION['conexao'], 0);
        if (bd_num_rows($result) == 0) {
            $existe=1;
        }
    }
    return $existe;
}

function get_atividade_tipo($id){
    $query = "SELECT * FROM cvsatividades_tipo where id=" . $id;
    return bd_fetch_assoc(bd_query($query, $_SESSION['conexao'], 0));
}

function get_perfil_completo($user_id){
    $query = "SELECT u.aniversario, u.telefone, u.linkedin, u.data_admissao, u.pratica, u.conhecimentos, u.lazer, u.desafios, u.sobre FROM cvsusuario_usuarios as u  WHERE u.regra_id=2 and u.id=".$user_id;
    $dados = bd_query($query,  $_SESSION['conexao'], 0);
    if (bd_num_rows($dados)>0) {
        $dado = bd_fetch_assoc($dados);
        if(strlen($dado['aniversario'])>0 && strlen($dado['telefone'])>0 &&
            $dado['data_admissao']!='0000-00-00' && $dado['pratica']!='0' && strlen($dado['conhecimentos'])>0 &&
            strlen($dado['lazer'])>0 && strlen($dado['desafios'])>0 && strlen($dado['sobre'])>0 &&
            $dado['avatar']!='http://www.mentorias.com.br/file/thumb/avatar.jpeg') {
            return 1;
        }else{
            return 0;
        }
    }else{
        return 0;
    }

}

function get_perfil_completo_array($dado){
          if(strlen($dado['aniversario'])>0 && strlen($dado['telefone'])>0 &&
            $dado['data_admissao']!='0000-00-00' && $dado['pratica']!='0' && strlen($dado['conhecimentos'])>0 &&
            strlen($dado['lazer'])>0 && strlen($dado['desafios'])>0 && strlen($dado['sobre'])>0 &&
            $dado['avatar']) {
            return 1;
        }else{
            return 0;
        }
}

function getNotificias(){
    $date = date('Y-m-d');
    if($_SESSION['usuario']['regra_id']==1){
        $where='(atv_atribuida_para=0 or atv_atribuida_para=1) ';
    }else{
        if($_SESSION['usuario']['conexao']==2){
            $where='(atv_atribuida_para=0 or atv_atribuida_para=2) ';
        }else{
            $where='(atv_atribuida_para=0 or atv_atribuida_para=1 or atv_atribuida_para=2) ';
        }

    }


    $sql = "Select atv_id, atv_titulo,atv_titulo_eng,atv_titulo_esp,atv_descricao,atv_descricao_eng,atv_descricao_esp, 
    a.criado_em, atv_data_inicio, a.alterado_em, pilar_id, cp.cor, 
    cp.nome as pilar_nome,
    cp.nome_eng as pilar_nome_eng,
    cp.nome_esp as pilar_nome_esp, 
    fil_nome,fil_id
    FROM atividades as a 
    left join cvspilares as cp on a.pilar_id=cp.id
    LEFT JOIN files AS f ON f.fil_origem_id = a.atv_id and fil_origem=4
    WHERE a.atv_tipo=6 and a.atv_status=1 and $where ORDER BY a.criado_em DESC LIMIT 0,10 ";
    $resultado = bd_query($sql, $_SESSION['conexao'], 0);


    if ($resultado) {
        $cont = bd_num_rows($resultado);

        $objs = array();
        if ($cont > 0) {
            while ($obj = bd_fetch_array_assoc($resultado)) {
                if($obj['fil_nome']!=''){
                    //$obj['url_img'] = FILE_ATIVIDADES . $obj['fil_nome'] . '?' . date('His');
                    $obj['url_img'] ="imagem?id=".$obj['fil_id'];
                }else{
                    $obj['url_img'] = PATH_ASSETS_IMG."placeholder.png";
                }
                $objs[] = $obj;
            }
        }
        $resposta['noticias'] = $objs;
        $resposta['error'] = "";
    } else {
        $resposta['error'] = lang('funcoes_erro_buscar_dados',1);
    }
    return $resposta;
}

function sugestoes_de_mentores(){
    $pilares_sol = sanitize_array(busca_user_pilares_sol( $_SESSION['usuario']['id']));
    //$grupo_cids=get_grupos_cid_usuario($_SESSION['usuario']['id']);

    $usuario=buscar_usuario($_SESSION['usuario']['id']);
    $inicio=0;
    $registros=500;
    $pilar="";
    $cargo="";
    $cargo_grupo="";
    $area="";

    $carreira=false;
    $permissao = 'and up.pilar_id in(';
    foreach ($pilares_sol as $pilar) {
        if($pilar['pilar_id']==1){
            $carreira=true;
        }
        $permissao.=$pilar['pilar_id'].",";
    }
    $permissao=substr($permissao, 0, -1);
    $permissao.=") ";

    if($carreira){
        $permissoes=$_SESSION['permissaoCargos'][$_SESSION['usuario']['cargo_grupo']];
        if(count($permissoes)==0){
            $whereCarreira=" and up.pilar_id<>1 ";
        }else{
            $whereCarre_str="";
            foreach ($permissoes as $per) {
                $whereCarre_str.= $per.",";
            }
            $whereCarre_str=substr($whereCarre_str, 0, -1);
            $whereCarreira="   and ((up.pilar_id=1 AND usr.cargo_grupo IN($whereCarre_str)) or (up.pilar_id<>1)) ";
        }
    }

    if($_SESSION['usuario']['cargo_grupo']==5 || $_SESSION['usuario']['cargo_grupo']==8){
        $whereNovosSocios="";
    }else{
        $whereNovosSocios="and up.pilar_id<>4 ";
    }

    $join="JOIN cvsusuario_pilares as up on up.usuario_id=usr.id and up.status=0 $whereNovosSocios $whereCarreira";
    $primeiro_acesso=" usr.primeiro_acesso<>0 and usr.status_mentoria=0 and ";

    $query = "SELECT distinct (usr.id), usr.id, usr.nome, usr.email,   usr.status_mentoria as status_mentoria, 
    primeiro_acesso,usr.alterado_em,aniversario,
    telefone,linkedin,data_admissao,conhecimentos,lazer,desafios,sobre
  
                FROM cvsusuario_usuarios as usr              
                $join
                WHERE $primeiro_acesso usr.id<>".$_SESSION['usuario']['id']." $permissao and 
                usr.status=1 and 
                usr.regra_id=2 and 
                (usr.nome like '%" . $campo . "%') " . $status.$cargo.$cargo_grupo.$area . "                
                 limit " . $inicio . "," . $registros;
    $resultado= bd_query($query, $_SESSION['conexao'], 0);



    $query = 'SELECT * FROM cvsmentoria as m Where m.status IN (0,1) and (m.solicitante_id='.$_SESSION['usuario']['id'].' OR m.mentor_id='.$_SESSION['usuario']['id'].')';
    $result2 = bd_query($query, $_SESSION['conexao'], 0);
    if(bd_num_rows($result2)>0){
        $mentore_indisponiveis = array();
        while($mentoria_existe = bd_fetch_array($result2)){
            if($mentoria_existe['mentor_id']==$_SESSION['usuario']['id']){
                $mentore_indisponiveis[] = $mentoria_existe['solicitante_id'];
            }else if($mentoria_existe['solicitante_id']==$_SESSION['usuario']['id']){
                $mentore_indisponiveis[] = $mentoria_existe['mentor_id'];
            }
        }
    }

    $result=array();
    $count=0;
    while ($objeto = bd_fetch_array($resultado)) {
        //echo "<br><br><br>".$objeto['nome']."";
        $avatar = busca_avatar_usuario($objeto['id']);
        $objeto['avatar'] = $avatar;
        $objeto['perfil_completo'] = get_perfil_completo_array($objeto);
        $objeto['qtd'] = count($pilares_sol);
        $objeto['pilares']= busca_pilares_usuario($objeto['id']);

        $objeto['pontos']=calcularPontuacao($objeto,$usuario,$pilares_sol,$grupo_cids);
        if($objeto['pontos']>0 && $count<500){
            if(!in_array($objeto['id'], $mentore_indisponiveis)) {
                $count++;
                $result[] = $objeto;
            }
        }


    }


    usort($result, 'cmpPontos');
    $result2 = array();
    $count=0;
    foreach ($result as $obj){
        if($count<=27){
            $result2[]=$obj;
        }
        $count++;
    }

    /*foreach ($result2 as $u){
        echo $u['nome']." - ".$u['pontos'].'<br>';
    }*/
    shuffle($result2);
    return $result2;
}

function calcularPontuacao($objeto,$usuario,$pilares_sol,$grupo_cids){
    $pontos=0;

    if($usuario['pratica']==$objeto['pratica_id']){
        $pontos+=15;
    }
    if($usuario['cargo']==$objeto['cargo_id']){
        $pontos+=15;
    }

    if($usuario['cargo_grupo']==$objeto['cargo_grupo_id']){
        $pontos+=15;
    }
    if($objeto['perfil_completo']) {
        $pontos+=5;
    }


    if($usuario['lazer']!='' && $objeto['lazer']!='')
        $pontos+=compararTexto($usuario['lazer'], $objeto['lazer']);

    if($usuario['conhecimentos']!='' && $objeto['conhecimentos']!='')
        $pontos+=compararTexto($usuario['conhecimentos'], $objeto['conhecimentos']);

    if($usuario['desafios']!='' && $objeto['desafios']!='')
        $pontos+=compararTexto($usuario['desafios'], $objeto['desafios']);

    if($usuario['sobre']!='' && $objeto['sobre']!='')
        $pontos+=compararTexto($usuario['sobre'], $objeto['sobre']);


    foreach ($pilares_sol as $pilar) {
        foreach ($objeto['pilares'] as $pilar2) {
            if ($pilar['pilar_id'] == $pilar2['pilar_id']) {
                if ($pilar['pilar_id'] == 1) {
                    $pontos+=20;
                }else{
                    $pontos+=5;
                }
            }
        }
    }

    foreach ($grupo_cids as $cid) {
        foreach ($objeto['grupo_cids'] as $cid2) {

            if ($cid['grupo_cid_id'] == $cid2['grupo_cid_id']) {
                $pontos+=10;
            }
        }
    }

    return $pontos;

}

function compararTexto($texto1, $texto2){

    $pontos=0;
    $texto1 = explode(" ", $texto1);
    $texto2 = explode(" ", $texto2);

    foreach ($texto1 as $palavra){
        if(in_array($palavra, $texto2)){
            $pontos+=2;
        }
    }

    return $pontos;
}

function cmpPontos($a, $b) {
    return $a['pontos'] < $b['pontos'];
}

function retorna_email_sessao($id) {
    $query = "SELECT `mentor_id`, `mentorado_id` FROM cvsatividades WHERE id = " . (int)$id;
    $resultado = bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));

    $query = "SELECT `email` FROM cvsusuario_usuarios WHERE id = " . (int)$resultado['mentor_id'];
    $resultado2 = bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));

    $query = "SELECT `email` FROM cvsusuario_usuarios WHERE id = " . (int)$resultado['mentorado_id'];
    $resultado3 = bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));

    $resposta = array(
        'mentor_id' => $resultado['mentor_id'],
        'mentor_email' => $resultado2['email'],
        'mentorado_id' => $resultado['mentorado_id'],
        'mentorado_email' => $resultado3['email'],
    );

    return $resposta;
}

function busca_dados_sessao($id,$hora_inicio=null,$hora_fim=null) {

    if ($hora_inicio != null && $hora_fim != null) {
        $query = "SELECT * FROM `cvsatividades` WHERE `inicio` = '" . $hora_inicio . "' AND `fim` = '". $hora_fim ."'";
        $resultado = bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
    } else {
        $query = "SELECT * FROM `cvsatividades` WHERE id = " . (int)$id;
        $resultado = bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
    }


    return $resultado;
}

function get_post_action($name) {
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}

function salvar_grupo($nome, $eng, $esp,$tipo)
{
    if ($nome != '') {
        $query = 'INSERT INTO cvsgrupos(nome, nome_eng, nome_esp, status,tipo, criado_em,alterado_em,criado_por,alterado_por) 
      VALUES ("' . $nome . '","' . $eng . '","' . $esp . '", 1,'.$tipo.',NOW(),NOW(),'.$_SESSION['usuario']['id'].','.$_SESSION['usuario']['id'].')';
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        if ($resultado) {
            return lang('funcoes_cadastrado_sucesso',1);
        } else {
            return lang('funcoes_erro_gravacao',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function editar_grupo( $area, $eng, $esp, $id)
{
    if ($area != '') {
        $query = 'UPDATE cvsgrupos SET nome="' . $area . '",nome_eng="' . $eng . '",nome_esp="' . $esp . '", alterado_em=NOW(), alterado_por='.$_SESSION['usuario']['id'].' WHERE id=' . (int)$id;
        $area = bd_query($query, $_SESSION['conexao'], 0);
        if ($area) {
            return lang('funcoes_editado_sucesso',1);
        } else {
            return lang('funcoes_erro_gravacao',1);
        }
    } else {
        return lang('funcoes_insira_campos_obrigatorios',1);
    }
}

function buscar_grupo($id)
{
    $query = "SELECT * FROM cvsgrupos WHERE id=" . (int)$id;

    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
}

function buscar_grupos($tipo)
{
    $query = "SELECT * FROM cvsgrupos WHERE tipo=" . $tipo. " Order by nome";
    return bd_query($query, $_SESSION['conexao'], 0);
}

function getPilaresSolUsuario($usuario_id, $programa_id=0){

    $where="";
    if($programa_id!=0){
        $where=" cp.programa_id=$programa_id AND ";
    }

    $query = "SELECT cp.nome as pilar, cp.nome_eng as pilar_eng, cp.nome_esp as pilar_esp, cp.cor as cor, p.pilar_id 
    FROM cvsusuario_pilares_sol as p 
    JOIN cvspilares as cp ON p.pilar_id=cp.id WHERE $where p.status=0 and usuario_id=" . $usuario_id;
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    $html="";
    $qtd=bd_num_rows($dados);
    $qtd2=0;
    if($qtd>0){
        while ($dado = bd_fetch_assoc($dados)) {
            if($qtd2<5){
                $html.=langBD($dado,'pilar',1).",";
                $qtd2++;
            }
        }
        if($qtd>5){
            $html.="+".($qtd-$qtd2);
        }else{
            $html=substr($html, 0, -1);
        }

    }

    return $html;
}

function getPilaresUsuario($usuario_id, $programa_id=0){

    $where="";
    if($programa_id!=0){
        $where=" cp.programa_id=$programa_id AND ";
    }

    $query = "SELECT cp.nome as pilar, cp.nome_eng as pilar_eng, cp.nome_esp as pilar_esp, cp.cor as cor, p.pilar_id 
    FROM cvsusuario_pilares as p 
    JOIN cvspilares as cp ON p.pilar_id=cp.id WHERE $where p.status=0 and usuario_id=" . $usuario_id;
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    $html="";
    $qtd=bd_num_rows($dados);
    $qtd2=0;
    if($qtd>0){
        while ($dado = bd_fetch_assoc($dados)) {
            if($qtd2<5){
                $html.=langBD($dado,'pilar',1).",";
                $qtd2++;
            }
        }
        if($qtd>5){
            $html.="+".($qtd-$qtd2);
        }else{
            $html=substr($html, 0, -1);
        }

    }

    return $html;
}

function getNumeroMentor($mentor_id){
    $query="SELECT * FROM cvsmentoria WHERE status=1 and mentor_id=$mentor_id";
    $resultado=bd_query($query,$_SESSION['conexao'],0);
    return bd_num_rows($resultado);
}

function verificaNroMentoriasMentorado($usuarioId){
    $query="SELECT count(id) as qtd FROM cvsmentoria WHERE status in (0,1) and solicitante_id=$usuarioId";
    $mentoriaIndividual=bd_fetch_assoc(bd_query($query,$_SESSION['conexao'],0));

    $query = "SELECT count(m.id) as qtd FROM cvsmentoria_mentorados as mm JOIN cvsmentoria m on mm.mentoria_id=m.id
                    WHERE mm.status=1 and  m.status in (0,1) and mentorado_id=" . $usuarioId;
    $mentoriaGrupo=bd_fetch_assoc(bd_query($query,$_SESSION['conexao'],0));

    $total=$mentoriaIndividual['qtd']+$mentoriaGrupo['qtd'];

    $quantidade=array();
    $quantidade['total']=$total;
    $quantidade['individual']=$mentoriaIndividual['qtd'];
    $quantidade['grupo']=$mentoriaGrupo['qtd'];
    return $quantidade;
}

function get_sessao($id){
    $query = "SELECT * FROM cvsatividades WHERE id = $id";
    return bd_fetch_assoc(bd_query($query, $_SESSION['conexao'], 0));
}

function busca_mentoria($id)
{



    $query = "SELECT m.*, p.cor as pilar_cor,p.nome as pilar, p.nome_eng as pilar_eng, p.nome_esp as pilar_esp, mentor.nome as mentor_nome, mentorado.nome as mentorado_nome,
    m.mentor_nota_mentoria as avaliacao_mentor, 
                m.mentorado_nota_mentoria as avaliacao_mentorado, 
                m.mentor_assunto_comentario as comentario_mentor, 
                m.mentorado_comentario_mentoria as comentario_mentorado
    FROM cvsmentoria as m
    JOIN cvsusuario_usuarios as mentor ON mentor.id=m.mentor_id
    JOIN cvsusuario_usuarios as mentorado ON mentorado.id=m.solicitante_id
    JOIN cvspilares as p on p.id=m.area_id     
    WHERE (solicitante_id=".$_SESSION['usuario']['id']." OR mentor_id=".$_SESSION['usuario']['id'].") and m.id=" . (int)$id;
    return bd_fetch_array(bd_query($query, $_SESSION['conexao'],0));

}

function busca_mentoria_admin($id)
{



    $query = "SELECT m.*, p.cor as pilar_cor,p.nome as pilar, p.nome_eng as pilar_eng, p.nome_esp as pilar_esp, mentor.nome as mentor_nome, mentorado.nome as mentorado_nome,
    m.mentor_nota_mentoria as avaliacao_mentor, 
                m.mentorado_nota_mentoria as avaliacao_mentorado, 
                m.mentor_assunto_comentario as comentario_mentor, 
                m.mentorado_comentario_mentoria as comentario_mentorado
    FROM cvsmentoria as m
    JOIN cvsusuario_usuarios as mentor ON mentor.id=m.mentor_id
    JOIN cvsusuario_usuarios as mentorado ON mentorado.id=m.solicitante_id
    JOIN cvspilares as p on p.id=m.area_id     
    WHERE  m.id=" . (int)$id;
    return bd_fetch_array(bd_query($query, $_SESSION['conexao'],0));

}

function get_atividade($id){
    $sql = "Select a.* FROM atividades as a WHERE  atv_id=$id";
    $resultado = bd_query($sql, $_SESSION['conexao'], 0);
    if ($resultado) {
        return bd_fetch_assoc($resultado);
    }else{
        header("HTTP/1.0 500 Internal Server Error");
        header('location: ../acesso/acesso_negado');
        exit;
    }

}


function getMentoriasAndamentoMentorado($userId){

    $query = "SELECT u.id,u.nome,m.status FROM cvsmentoria as m 
        JOIN cvsusuario_usuarios AS u ON m.mentor_id=u.id
        WHERE (m.status=1 or m.status=0) and solicitante_id=" . $userId;
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    $html="";
    $qtd=bd_num_rows($dados);
    if($qtd>0){
        while ($dado = bd_fetch_assoc($dados)) {
            if($dado['status']==0){
                $html.="<a href=\"javascript:;\" style='color:red' onclick=\"visualizar_participante_admin('".$dado['id']."')\"  ># ".resume_nome($dado['nome'])."</a><br>";
            }else if($dado['status']==1){
                $html.="<a href=\"javascript:;\"  onclick=\"visualizar_participante_admin('".$dado['id']."')\"  >".resume_nome($dado['nome'])."</a><br>";
            }

        }
        $html=substr($html, 0, -4);
    }else{
        $html='';

    }
    return $html;
}
require(__DIR__."/FC_Grupo.php");

function getMentoriasAndamentoMentor($userId){

    $query = "SELECT u.id,u.nome,m.status FROM cvsmentoria as m 
        JOIN cvsusuario_usuarios AS u ON m.solicitante_id=u.id
        WHERE (m.status=1 or m.status=0) and mentor_id=" . $userId;
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    $html="";
    $qtd=bd_num_rows($dados);
    if($qtd>0){
        while ($dado = bd_fetch_assoc($dados)) {
            if($dado['status']==0){
                $html.="<a href=\"javascript:;\" style='color:red' onclick=\"visualizar_participante_admin('".$dado['id']."')\"  ># ".resume_nome($dado['nome'])."</a><br>";
            }else if($dado['status']==1){
                $html.="<a href=\"javascript:;\"  onclick=\"visualizar_participante_admin('".$dado['id']."')\"  >".resume_nome($dado['nome'])."</a><br>";
            }

        }
        $html=substr($html, 0, -4);
    }else{
        $html='';

    }
    return $html;
}
