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
























function getCards() {
    $query = "SELECT ts.*, 
            JOIN `user` AS tu ON tu.id = ts.fk_idUsuario
            JOIN `categoria` AS tc ON c.id = ts.fk_idCategoria
            FROM `service` AS ts";
    return bd_fetch_assoc(bd_query($query, $_SESSION['conexao'], 1));
}