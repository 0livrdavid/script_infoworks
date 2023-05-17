<?php
$conexao = bd_Conexao($database_server, $database_username, $database_password, $database_name);
$_SESSION['conexao'] = $conexao;

$_POST=seguro_array($_POST);
$_GET=seguro_array($_GET);

sanitizeXSS();

function bd_Conexao($database_server, $database_username, $database_password, $database_name){
    $conexao = mysqli_connect($database_server, $database_username, $database_password, $database_name)
    or exit("Erro ao tentar se conectar ao Banco de Dados : " . mysqli_connect_error());

    mysqli_set_charset($conexao,"utf8") or exit("Erro ao setar charset.");

    $conexao_bd = mysqli_select_db($conexao, $database_name)
    or exit("Erro ao Usar BD : " . mysqli_error($conexao));

    return $conexao;
}

function bd_query($str_sql, $str_conexao, $ver_dados = 0){
    $qry = mysqli_query($str_conexao, $str_sql);
    $erro = mysqli_error($str_conexao);
    if ($ver_dados == 1) {
        echo '<br>[Query = ' . $str_sql . '] [Banco = ] [Erro = ' . $erro . ']';
    } else if ($ver_dados == 2) {
        return '[Query = ' . $str_sql . '] [Banco = ] [Erro = ' . $erro . ']';
    }else if ($ver_dados == 3) {
        return '[Erro = ' . $erro . ']';
    }
  return $qry;
}

function bd_fetch_row($res) {
    return mysqli_fetch_row($res);
}

function bd_fetch_array($res) {
    return htmlspecialchars_recursive(mysqli_fetch_array($res));
}

function bd_fetch_assoc($res) {
    return htmlspecialchars_recursive(mysqli_fetch_assoc($res));
}

function htmlspecialchars_recursive ($input, $flags = ENT_COMPAT | ENT_HTML401, $encoding = 'UTF-8', $double_encode = false) {
    return sanitize_array($input);
}

function bd_fetch_array_assoc($res) {
    return mysqli_fetch_assoc($res);
}

function bd_num_rows($res) {
    return mysqli_num_rows($res);
}

function bd_affect_rows() {
    return mysqli_affected_rows($_SESSION['conexao']);
}

function abrir(){
    mysqli_begin_transaction($_SESSION['conexao'], MYSQLI_TRANS_START_READ_WRITE);
}

function commit(){
    mysqli_commit($_SESSION['conexao']);
}

function rollback(){
    mysqli_rollback($_SESSION['conexao']);
}

function bd_sql_to_array_assoc($conexao, $sql, $mostarDados = 0){
    $array = array();

    $query = bd_query($sql, $conexao, $mostarDados);

    while ($row = mysqli_fetch_assoc($query)) {
        $array[] = $row;
    }

    return $array;
}

function bd_to_array($resultado){
    $array = array();
    while ($row = mysqli_fetch_assoc($resultado)) {
        $array[] = $row;
    }

    return $array;
}


function sanitizeXSS () {
    $_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $_REQUEST = (array)$_POST + (array)$_GET + (array)$_REQUEST;
}

function seguro_array($arrays) {
    $array_aux = array();
    foreach ($arrays as $key => $array) {
        if (is_array($array)) {
            $array_sub_aux = array();
            foreach ($array as $key_sub => $array_sub) {
                if (is_array($array_sub)) {
                    $array_sub2_aux = array();
                    foreach ($array_sub as $key_sub2 => $array_sub2) {
                        if (is_array($array_sub2)) {
                            $array_sub3_aux = array();
                            foreach ($array_sub2 as $key_sub3 => $array_sub3) {

                            //    $array_sub3=preg_replace('/[^[:alpha:]_]/', '',$array_sub3);
                                $array_sub3=strip_tags($array_sub3, '<p><a><br><b><font><span><ol><li><div><br>');
                                $array_sub3 = str_replace(array("\\r","\\n","\\'"), array("\r","\n","\'"), $array_sub3);
                                $array_sub3 = mysqli_real_escape_string($_SESSION['conexao'],$array_sub3);
                                $array_sub3_aux[$key_sub3] = $array_sub3;
                            }
                            $array_sub2_aux[$key_sub2] = $array_sub3_aux;
                        } else {
                           // $array_sub2=preg_replace('/[^[:alpha:]_]/', '',$array_sub2);
                            $array_sub2=strip_tags($array_sub2, '<p><a><br><b><font><span><ol><li><div><br>');
                            $array_sub2 = str_replace(array("\\r","\\n","\\'"), array("\r","\n","\'"), $array_sub2);
                            $array_sub2 = mysqli_real_escape_string($_SESSION['conexao'],$array_sub2);
                            $array_sub2_aux[$key_sub2] = $array_sub2;
                        }

                    }
                    $array_sub_aux[$key_sub] = $array_sub2_aux;
                } else {

                   // $array_sub=preg_replace('/[^[:alpha:]_]/', '',$array_sub);
                    $array_sub=strip_tags($array_sub, '<p><a><br><b><font><span><ol><li><div><br>');
                    $array_sub = str_replace(array("\\r","\\n","\\'"), array("\r","\n","\'"), $array_sub);
                    $array_sub = mysqli_real_escape_string($_SESSION['conexao'],$array_sub);
                    $array_sub_aux[$key_sub] = $array_sub;
                }
            }
            $array_aux[$key] = $array_sub_aux;
        } else {
          //  $array=preg_replace('/[^[:alpha:]_]/', '',$array);
            $array=strip_tags($array, '<p><a><br><b><font><span><ol><li><div><br>');
            $array = str_replace(array("\\r","\\n","\\'"), array("\r","\n","\'"), $array);
            $array = mysqli_real_escape_string($_SESSION['conexao'],$array);
            $array_aux[$key] = $array;
        }
    }
    return $array_aux;
}

function seguro_print($arrays){
    $array_aux = array();
    foreach ($arrays as $key => $array) {
        if (is_array($array)) {
            $array_sub_aux = array();
            foreach ($array as $key_sub => $array_sub) {
                if (is_array($array_sub)) {
                    $array_sub2_aux = array();
                    foreach ($array_sub as $key_sub2 => $array_sub2) {
                        if (is_array($array_sub2)) {
                            $array_sub3_aux = array();
                            foreach ($array_sub2 as $key_sub3 => $array_sub3) {
                                $array_sub3=html_entity_decode($array_sub3);
                                $array_sub3_aux[$key_sub3] = $array_sub3;
                            }
                            $array_sub2_aux[$key_sub2] = $array_sub3_aux;
                        } else {
                            $array_sub2=html_entity_decode($array_sub2);
                            $array_sub2_aux[$key_sub2] = $array_sub2;
                        }

                    }
                    $array_sub_aux[$key_sub] = $array_sub2_aux;
                } else {
                    $array_sub=html_entity_decode($array_sub);
                    $array_sub_aux[$key_sub] = $array_sub;
                }
            }
            $array_aux[$key] = $array_sub_aux;
        } else {
            $array=html_entity_decode($array);
            $array_aux[$key] = $array;
        }
    }
    return $array_aux;
}

function seguroMysql($value){
    $value = mysqli_real_escape_string($_SESSION['conexao'],$value);
    return $value;
}


function bd_last_id($res=null){
    return mysqli_insert_id($_SESSION['conexao']);
}

function bd_sql_to_array($conexao, $sql, $mostarDados = 0){
    $array = array();
    $i     = 0;

    $query = bd_query($sql, $conexao, $mostarDados);

    while ($row = mysqli_fetch_assoc($query)) {
        $array[$i] = $row;
        $i++;
    }

    return $array;
}

function bd_first($conexao, $sql, $mostarDados = 0){
    $aux = bd_sql_to_array($conexao, $sql, $mostarDados);

    return $aux[0];
}

function bd_sql_to_list($conexao, $sql, $mostarDados = 0){
    $aux = bd_sql_to_array($conexao, $sql, $mostarDados);

    return $aux[0];
}

function resTotalLength($conexao, $flag, $primaryKey, $table){
    $query = "SELECT COUNT({$primaryKey}) FROM  $table";
    $resTotalLength = bd_query($query, $conexao, $flag);
    $resTotalLength = bd_fetch_array($resTotalLength);
    return $resTotalLength[0];
}

function encrypt_password($password, $salt){
    return base64_encode(pbkdf2_calc('sha1', $password, $salt, 10000, 1));
}

if (!function_exists('pbkdf2_calc')) {
    function pbkdf2_calc($hash, $password, $salt, $iterations, $length)
    {
        $num = ceil($length / output_size_hmac($hash, true));
        $result = '';
        for ($block = 1; $block <= $num; $block++) {
            $hmac = hash_hmac($hash, $salt . pack('N', $block), $password, true);
            $mix = $hmac;
            for ($i = 1; $i < $iterations; $i++) {
                $hmac = hash_hmac($hash, $hmac, $password, true);
                $mix ^= $hmac;
            }
            $result .= $mix;
        }

        return substr($result, 0, $length);
    }
}

if (!function_exists('output_size_hmac')) {
    function output_size_hmac($hash, $output = false)
    {
        return strlen(compute_hmac('key', $hash, 'data', $output));
    }
}

if (!function_exists('compute_hmac')) {
    function compute_hmac($key, $hash, $data, $output = false)
    {
        if (empty($key)) {
            echo "chave nula ou vazia";

            return null;
        }

        return hash_hmac($hash, $data, $key, $output);
    }
}



function sanitize_string($string){ # limpa a string removendo XSS injection
    return html_entity_decode(htmlspecialchars($string, ENT_QUOTES, 'UTF-8'));
}

function sanitize_array($arrays) {
    $array_aux = [];
    if(is_array($arrays)) {
        foreach ($arrays as $key => $array) {
            if (is_array($array)) {
                $array_sub_aux = array();
                foreach ($array as $key_sub => $array_sub) {
                    if (is_array($array_sub)) {
                        $array_sub2_aux = array();
                        foreach ($array_sub as $key_sub2 => $array_sub2) {
                            if (is_array($array_sub2)) {
                                $array_sub3_aux = array();
                                foreach ($array_sub2 as $key_sub3 => $array_sub3) {
                                    $array_sub3 = sanitize_string($array_sub3);
                                    $array_sub3_aux[$key_sub3] = $array_sub3;
                                }
                                $array_sub2_aux[$key_sub2] = $array_sub3_aux;
                            } else {
                                $array_sub2 = sanitize_string($array_sub2);
                                $array_sub2_aux[$key_sub2] = $array_sub2;
                            }
                        }
                        $array_sub_aux[$key_sub] = $array_sub2_aux;
                    } else {
                        $array_sub = sanitize_string($array_sub);
                        $array_sub_aux[$key_sub] = $array_sub;
                    }
                }
                $array_aux[$key] = $array_sub_aux;
            } else {
                $array = sanitize_string($array);
                $array_aux[$key] = $array;
            }
        }
    }
    return $array_aux;
}


function bd_iteration($sql){
    while ($dado = bd_fetch_assoc($sql)) {
        $dados[] = $dado;
    }
    return $dados;
}

function bd_iterate_query_update($datas, $table, $where = ""){
    abrir();
    $sql = array();
    $result = array();

    foreach ($datas as $data_name => $data_value) {
        $sql[] = "UPDATE $table SET $data_name = '$data_value' $where";
    }

    foreach ($sql as $query) {
        $result[] = bd_query($query, $_SESSION['conexao'], 2);
        if (bd_affect_rows() <= 0) {
            rollback();
            return ['flag' => false, 'sql' => $sql, 'result' => $result, 'field' => bd_query($query, $_SESSION['conexao'], 3)];
        }
    }
    
    commit();
    return ['flag' => true, 'sql' => $sql, 'result' => $result, 'field' => ""];
}

function bd_iterate_query_insert($datas, $table){
    $columns = array_keys($datas);
    $values = array_values($datas);

    $columns_str = implode(", ", $columns);
    $values_str = "'" . implode("', '", $values) . "'";

    $sql = "INSERT INTO $table ($columns_str) VALUES ($values_str)";

    $result = bd_query($sql, $_SESSION['conexao'], 2);

    if ($result === false) {
        return ['flag' => false, 'sql' => $sql, 'result' => bd_query($sql, $_SESSION['conexao'], 3)];
    }

    return ['flag' => true, 'sql' => $sql, 'result' => $result, 'inserted_id' => bd_last_id()];
}














function getCards($filter) {
    $query = "SELECT s.*,s.fk_idCategory AS categoria, s.valor, s.fk_idType AS tipoValor, u.nome, u.idade
            FROM `service` AS s
            JOIN `user` AS u ON u.id = s.fk_idUsuario
            WHERE s.status = 1";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    return bd_iteration($dados);
}

function getServices() {
    $query = "SELECT s.*
            FROM `service` AS s
            WHERE fk_idUsuario = {$_SESSION['idUsuario']}";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    return bd_iteration($dados);
}

function getService($id) {
    $query = "SELECT s.*
            FROM `service` AS s
            WHERE fk_idUsuario = {$_SESSION['idUsuario']}";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    return bd_iteration($dados);
}

function getFilesService($service) {
    $query = "SELECT f.*
            FROM `service_file` AS sf
            JOIN file AS f ON f.id = sf.fk_idFile
            WHERE fk_idService = $service";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    return bd_iteration($dados);
}

function createUser($user) {
    $password = encryptPassword($user['password']);

    $query = 'INSERT INTO user (status, tipo, autorizado,
                                cpf, email, idade,
                                senha, hash, salt,
                                nome) VALUES
                                 (1,3,0,
                                 "'.$user['cpf'].'","'.$user['email'].'","'.transformar_data($user['data_nascimento']).'",
                                 "'.$password['password'].'", "'.$password['hash'].'", "'.$password['salt'].'",
                                 "'.$user['nome'].'")';
    $dados = bd_query($query, $_SESSION['conexao'], 0);

    return $dados;
}


function encryptPassword($password) {
    $salt = md5(uniqid(rand(), true));
    $hash = sha1($salt . $password . $salt);
    // Retorna a hash gerada para uso posterior
    return ["password" => $password, "hash" => $hash, "salt" => $salt];
}


function transformar_data($data) {
    // separa o valor em dia, mês e ano
    $partes = explode('/', $data);
    
    // inverte a ordem para ano-mês-dia
    $data_formatada = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
    
    return $data_formatada;
}

function converte_data($data) {
    // separa o valor em dia, mês e ano
    $partes = explode('-', $data);
    
    // inverte a ordem para ano-mês-dia
    $data_formatada = $partes[2] . '/' . $partes[1] . '/' . $partes[0];
    
    return $data_formatada;
}