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

function bd_affected_rows($res){
    if ($GLOBALS['db'] == 'sybase') {
        $ret = sybase_affected_rows($res);
    } else if ($GLOBALS['db'] == 'mysql') {
        $ret = mysql_affected_rows($res);
    } else if ($GLOBALS['db'] == 'mysqli') {
        $ret = mysqli_affected_rows($res);
    } else if ($GLOBALS['db'] == 'mssql') {
        if (function_exists('mssql_rows_affected')) {
            return mssql_rows_affected($res);
        } else {
            $result = mssql_query("select @@rowcount as rows", $res);
            $rows   = mssql_fetch_assoc($result);

            return $rows['rows'];
        }
    } else if ($GLOBALS['db'] == 'oracle') {
        if (is_resource($res)) {
            $ret = oci_num_rows($res);
        }
    } else
        if ($GLOBALS['db'] == 'db2') {
            $ret = db2_num_rows($res);
        } else
            if ($GLOBALS['db'] == 'odbc') {
                $ret = odbc_num_rows($res);
            }

    return $ret;
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

function function_data_query($conexao, $flag, $request, $columns, $where_default, $where_session, $table, $order = ''){
    $data=array();
    $limit = limit($request, $columns);
    if ($order != '') {

    } else {
        $order = order($request, $columns);
    }

    $where = filter_generico($request, $columns, $where_default, $where_session);


    $query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", pluck($columns, 'db')) . "
       FROM $table
       $where
       $group
       $order
       $limit";

    if ($filtro == 1) {
        $_SESSION['filtro'] = "SELECT *
       FROM $table
       $where
       $group
       $order
       $limit";
    }
    if ($filtro == 2) {
        $_SESSION['filtro1'] = "SELECT *
       FROM $table
       $where
       $group
       $order
       $limit";
    }

    $resultado = bd_query($query, $conexao, $flag);
    while ($dado = bd_fetch_array($resultado)) {
        $data[] = $dado;
    }
    return $data;
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

















function getCards($filter) {
    $query = "SELECT s.fk_idCategoria AS categoria, s.valor, s.tipoValor, u.nome, u.idade
            FROM `service` AS s
            JOIN `user` AS u ON u.id = s.fk_idUsuario
            JOIN `categoria` AS c ON c.nome = s.fk_idCategoria
            WHERE s.status = 1";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    while ($dado = bd_fetch_assoc($dados)) {
        $cards[] = $dado;
    }
    return $cards;
}

function createUser($user) {
    $encrypt = (array) encryptPassword($user['password']);

    $query = "INSERT INTO `user`(`status`, `tipo`, `autorizado`,
                                `cpf`, `email`, `idade`,
                                `nome`, `senha`, `salt`) VALUES
                                 (1,3,0,
                                 '".$user['cpf']."','".$user['email']."','".corrigirData($user['data_nascimento'])."',
                                 '".$user['nome']."', '".$encrypt['password']."', '".$encrypt['salt']."')";
    //$dados = bd_query($query, $_SESSION['conexao'], 0);

    $dados = true;
    return $dados;
}

function encryptPassword($password) {
    // Gerando salt aleatório
    $options = [
        'cost' => 12, // número de iterações de hash
    ];
    $salt = password_hash('', PASSWORD_BCRYPT, $options);

    // Criptografando a senha com o salt
    $hash = password_hash($password . $salt, PASSWORD_BCRYPT, $options);

    return ["password"=> $hash, "salt"=> $salt];
}


function corrigirData($data) {
    // Verificando se a data está no formato correto
    if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data)) {
        throw new Exception('Data inválida!');
    }

    // Convertendo a data para formato datetime
    $data_formatada = DateTime::createFromFormat('d/m/Y', $data);

    if (!$data_formatada) {
        throw new Exception('Data inválida!');
    }

    return $data_formatada->format('Y-m-d');
}