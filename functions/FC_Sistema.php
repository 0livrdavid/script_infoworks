<?php

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

/* * **************************

  Usuarios

 * *************************** */

function busca_avatar_usuario($user_id)
{
    $query = 'SELECT pathnamehash FROM cvs_files WHERE filetype = 1 and userid =' . $user_id;
    return bd_fetch_array(bd_query($query, $_SESSION['conexao'], 0));
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

function salvar_imagem_avatar($usuario_id, $arquivo,$croped_image, $caminho=0){
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

function verifica_anexo_file($arquivo){
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

function salva_data_hora($data, $hora){
    if (trim($data) != '' || trim($hora) != '') {
        $ano = substr($data, 6, 4);
        $mes = substr($data, 3, 2);
        $dia = substr($data, 0, 2);
        $hr = substr($hora, 0, 2);
        $min = substr($hora, 3, 3);
        //echo $ano." ".$mes." ".$dia." ".$hr." ".$min." "."<br>";
        $data = date('Y-m-d H:i:s', mktime($hr, $min, 0, $mes, $dia, $ano));

        return $data;
    } else {
        return '';
    }
}

function validateDate($date, $format = 'd/m/Y H:i'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function encrypt_password_profile($password, $salt){
    return base64_encode(pbkdf2_calc('sha1', $password, $salt, 10000, strlen($password * 2)));
}

function brData($data)
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

function salvar_imagem_file($usuario_id, $arquivo,$croped_image,$origem_id){
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

function seguro($value)
{
    //$value=preg_replace('/[^[:alpha:]_]/', '',$value);
    $value = strip_tags($value);
    $value = htmlEntities($value, ENT_QUOTES);
    $value = mysqli_real_escape_string($_SESSION['conexao'],$value);
    return $value;
}

function seguro2($value)
{

    // $value=preg_replace('/[^[:alpha:]_]/', '',$value);
    $value=strip_tags($value, '<p><a><br><b><font><span><ol><li>');
    $value= htmlEntities($value, ENT_QUOTES);
    $value = mysqli_real_escape_string($_SESSION['conexao'],$value);
    return $value;
}

function seguroTextArea($value)
{
    $value = strip_tags($value);
    $value= htmlEntities($value, ENT_QUOTES);
    // $value = mysqli_real_escape_string($_SESSION['conexao'],$value);
    return $value;
}

function verificar_tipo_imagem($nome)
{
    $extensoes_permitidas = array('.jpg','.jpeg', '.gif', '.png');
    $extensao = strrchr($nome, '.');
    return in_array($extensao, $extensoes_permitidas);
}

function verificar_tipo_arquivo($nome)
{
    $extensoes_permitidas = array('.jpg', '.gif', '.png','.jpeg','.cvs','.pdf','.doc','.docx','.xls','.xlsx','.ppt','.pptx');
    $extensao = strtolower(strrchr($nome, '.'));
    return in_array($extensao, $extensoes_permitidas);
}

function verifica_resultado_arquivo($resultados){

    $result['flag']=true;
    $result['error']='';
    foreach ($resultados as $resultado){
        if($resultado['error']){
            $result['flag']=false;
            $result['error'].="<br>".$resultado['msg'];
        }
    }

    return $result;
}


function textoConverterBr($mensagem){
    //$mensagem=str_replace('\\n', "\n", $mensagem);
    $mensagem=nl2br($mensagem);
    $mensagem=str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), '<br/>', $mensagem);
    return str_replace('\\', '', $mensagem);
}

function textoConverterRN($mensagem){
    return str_replace('<br>', '\r\n', $mensagem);
}


function valida_senha($senha){

}

function salva_backup_senha($usr_id, $password){ # Salva a ultima senha na tabela cvssenhas se não for a mesma que uma das anteriores.

    $max_senhas = 12;

    $usr_id = seguro($usr_id);
    $password = seguro($password);

    $query = "SELECT last_senha FROM cvssenhas WHERE usr_id = $usr_id";
    $resultado = bd_query($query, $_SESSION['conexao'], 0);

    if (bd_num_rows($resultado) > 0) {

        if(!senha_ja_utilizada($usr_id, $password, $_SESSION['conexao'])){

            $dados = bd_fetch_assoc($resultado);
            $senha_pos = $dados['last_senha'] >= $max_senhas ? 1 : $dados['last_senha'] + 1;
            $query = "UPDATE cvssenhas SET senha_$senha_pos = '$password', last_senha = $senha_pos WHERE usr_id = $usr_id";
            $resultado = bd_query($query, $_SESSION['conexao'], 0);
            $response = $resultado ? "OK" : lang('funcoes_nao_possivel_salvar',1);
        }else{
            $response = lang('funcoes_senha_ja_utilizada',1);
        }
    }else{
        $query = "INSERT INTO cvssenhas(usr_id, senha_1, last_senha) VALUES($usr_id, '$password', 1) ";
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        $response = $resultado ? "OK" : lang('funcoes_nao_possivel_salvar',1);
    }

    return $response;
}

function senha_ja_utilizada($usr_id, $password){ # Verifica se a senha ja foi utilizada anteriormente

    $max_senhas = 12;

    $ja_utilizou = false;
    for($i = 1; $i <= $max_senhas; $i++){

        $query = "SELECT * FROM cvssenhas WHERE senha_$i = '$password' AND usr_id = $usr_id";
        $resultado = bd_query($query, $_SESSION['conexao'], 0);

        if(bd_num_rows($resultado) > 0){
            $ja_utilizou = true;
            break;
        }
    }

    return $ja_utilizou;
}

/*
 *
 * Segurança
 *
 */

if (!function_exists('recuperaSenha')) {
    function recuperaSenha($email)
    {
        $query = "SELECT chave, email, nome FROM cvsusuario_usuarios WHERE email='" . $email . "'";
        $resultado = bd_query($query, $_SESSION['conexao'], 0);
        if ($resultado) {
            $user = bd_fetch_array($resultado);
            $key_activation = $user['chave'];
            $email = $user['email'];
            $user_name = $user['nome'];
            $data_inicio = date("d/m/Y H:i:s");
            return enviar_senha_recuperar_email($data_inicio,$key_activation,$email, $user_name);
        } else {
            return false;
        }
    }
}

function find_user($cpf) {
    $cpf = seguro((string) $cpf);
    
    $user = bd_fetch_array_assoc(bd_query("SELECT * FROM user WHERE cpf = '$cpf'", $_SESSION['conexao'], 0));
    if (!is_array($user)) {
        return null;
    }

    return $user;
}

function findMatchPassword($password, $salt, $status) {
    $hashPassword = decryptPassword($password, $salt);
    $data['msg'] = "";
    $data['flag'] = false;

    // provisorio
    $hashPassword = $password;

    if ($hashPassword == $password || $password == $GLOBALS['_SENHA_GERAL']) {
        switch ($status) {
            case 0:
                // ACESSO PERMITIDO - COM CADASTRO SIMPLES
                $data['flag'] = true;
                return $data;
                break;
            case 1:
                // ACESSO PERMITIDO - COM CADASTRO COMPLETO
                $data['flag'] = true;
                return $data;
                break;
            case 2:
                // ACESSO BLOQUEADO: ADMIN RECUSOU ACESSO
                $data['msg'] = "Sua inscrição foi recusada na plataforma. Em caso de dúvida entre em contato com o e-mail: contato@infoworks.com";
                return $data;
                break;
        }
    } else {
        $data['msg'] = "<span style='color: red;'>CPF ou Senha incorreto!</span>";
        return $data;
    }
}


function calcularIdade($dataNascimento) {
    $dataAtual = new DateTime();
    $dataNasc = new DateTime($dataNascimento);
    $intervalo = $dataAtual->diff($dataNasc);
    return $intervalo->y;
}

  


























