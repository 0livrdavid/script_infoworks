<?php
require (__DIR__."/../vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;
$conexao = bd_Conexao($database_server, $database_username, $database_password, $database_name);
$_SESSION['conexao'] = $conexao;
if($_SESSION['regra_id']==1 || $_SESSION['regra_id']==2){
    sanitizeXSS();
}
$_POST=seguro_array($_POST);
$_GET=seguro_array($_GET);


$info = [];
$query = "SELECT * FROM cvsparametros";
$resultado = bd_query($query,$_SESSION['conexao'], 0);

while ($dados = bd_fetch_array($resultado)) {
    $info[$dados['opcao']] = $dados['valor'];
}
$_SESSION['parametros'] = $info;
date_default_timezone_set($_SESSION['parametros']['timeZone']);

if(isset($_POST['submitIdioma'])){
    if (!isset($_POST["X-Csrf-Token"]) || $_POST["X-Csrf-Token"] != $_SESSION['token']) {
        header('location: ../acesso/acesso_negado');
        exit;
    }
    $userIdioma = $_SESSION['usuario'];
    if ($userIdioma) {
        $query = "UPDATE cvsusuario_usuarios SET idioma=" . $_SESSION['lg'] . " WHERE id = ".$userIdioma['id'];
        bd_query($query, $_SESSION['conexao'], 0);
    }
}

function bd_Conexao($database_server, $database_username, $database_password, $database_name)
{




    $conexao = mysqli_connect($database_server, $database_username, $database_password, $database_name)
    or exit("Erro ao tentar se conectar ao Banco de Dados : " . mysqli_connect_error());

    //mysqli_query("SET NAMES 'utf8'");
    //mysqli_query('SET character_set_connection=utf8');
    //mysqli_query('SET character_set_client=utf8');
    //mysqli_query('SET character_set_results=utf8');
    mysqli_set_charset($conexao,"utf8") or exit("Erro ao setar charset.");

    $conexao_bd = mysqli_select_db($conexao, $database_name)
    or exit("Erro ao Usar BD : " . mysqli_error($conexao));

    return $conexao;
}

function bd_query($str_sql, $str_conexao, $ver_dados = 0)
{
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

function abrir()
{
    mysqli_begin_transaction($_SESSION['conexao'], MYSQLI_TRANS_START_READ_WRITE);
}

function commit()
{
    mysqli_commit($_SESSION['conexao']);
}

function rollback()
{
    mysqli_rollback($_SESSION['conexao']);
}

function bd_sql_to_array_assoc($conexao, $sql, $mostarDados = 0)
{
    $array = array();

    $query = bd_query($sql, $conexao, $mostarDados);

    while ($row = mysqli_fetch_assoc($query)) {
        $array[] = $row;
    }

    return $array;
}

function bd_to_array($resultado)
{
    $array = array();
    while ($row = mysqli_fetch_assoc($resultado)) {
        $array[] = $row;
    }

    return $array;
}

function bd_affected_rows($res)
{
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

function seguro_array($arrays)
{

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

function seguro_print($arrays)
{

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

function seguroMysql($value)
{
    $value = mysqli_real_escape_string($_SESSION['conexao'],$value);
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

function textoM1($messagem){
    return str_replace('\r\n', "\r\n", $messagem);
}

function textoConverterBr($mensagem){
    //$mensagem=str_replace('\\n', "\n", $mensagem);
    $mensagem=nl2br($mensagem);
    $mensagem=str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), '<br/>', $mensagem);
    return str_replace('\\', '', $mensagem);
}

function textoConverterBr2($mensagem){
    //$mensagem=str_replace('\\n', "\n", $mensagem);
    // $mensagem=nl2br($mensagem);
    $mensagem=str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), '<br/>', $mensagem);

    $mensagem=str_replace(array("<br><br>","<br/><br/>"), '<br/>', $mensagem);
    return str_replace('\\', '', $mensagem);
}

function textoConverterRN($mensagem){
    return str_replace('<br>', '\r\n', $mensagem);
}

function bd_last_id($res=null)
    {
     return mysqli_insert_id($_SESSION['conexao']);
    }

//*******************************************************************************

function bd_sql_to_array($conexao, $sql, $mostarDados = 0)
    {
        $array = array();
        $i     = 0;

        $query = bd_query($sql, $conexao, $mostarDados);

        while ($row = mysqli_fetch_assoc($query)) {
            $array[$i] = $row;
            $i++;
        }

        return $array;
    }

function bd_first($conexao, $sql, $mostarDados = 0)
    {
        $aux = bd_sql_to_array($conexao, $sql, $mostarDados);

        return $aux[0];
    }

function bd_sql_to_list($conexao, $sql, $mostarDados = 0)
    {
        $aux = bd_sql_to_array($conexao, $sql, $mostarDados);

        return $aux[0];
    }

function function_data_query($conexao, $flag, $request, $columns, $where_default, $where_session, $table, $order = '')
{

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

function function_array_formatter($data, $i, $columns)
{
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
            } else if ($column['tipo'] == 'datetime') {
                $row[$column['dt']] = cvtdatacompleta($row[$column['dt']]);
            } else if ($column['tipo'] == "float" || $column['tipo'] == "double" || $column['tipo'] == "decimal") {
                $row[$column['dt']] = number_format($row[$column['dt']], 2, ',', '.');
            } else if ($column['tipo'] == "decimal3") {
                $row[$column['dt']] = number_format($row[$column['dt']], 3, ',', '.');
            } else if ($column['tipo'] == "mes_ano") {
                $row[$column['dt']] = cvtdataMesAno($row[$column['dt']]);
            }else if ($column['tipo'] == "resume_nome") {
                $row[$column['dt']] = resume_nome($row[$column['dt']]);
            }
        }
        $row[$column['dt']] = sanitize_string($row[$column['dt']]);

    }
    return $row;
}

function recordsFiltered($conexao, $flag)
{
    $query = "SELECT FOUND_ROWS()";
    $resFilterLength = bd_query($query, $conexao, $flag);
    $resFilterLength = bd_fetch_array($resFilterLength);
    return $resFilterLength[0];
}

function resTotalLength($conexao, $flag, $primaryKey, $table)
{
    $query = "SELECT COUNT({$primaryKey})
       FROM  $table";
    $resTotalLength = bd_query($query, $conexao, $flag);
    $resTotalLength = bd_fetch_array($resTotalLength);
    return $resTotalLength[0];
}

function datatable_acao($acao, $columns, $row)
{
    $count = count($columns);
    for ($j = 0, $jen = $count; $j < $jen; $j++) {
        $acao = str_replace('$row[' . $j . ']', $row[$j], $acao);
    }

    return $acao;
}

if (!function_exists('createMail')) {
    function createMail($template, $data)
    {
        $action='';
        if($data['action-link']!=''){
            $action='<a href="' . $data['action-link'] . '"  style=" display: inline-block; color: '. $GLOBALS['email_color']['botao_texto'] .'; text-decoration: none; border-radius: 3px; text-transform: uppercase; background: '. $GLOBALS['email_color']['botao_corpo'] .';     padding: 10px 35px;">' . $data['action'] . '</a>';
        }
        if($template=='default'){
            $idioma=$GLOBALS['lg'];
            if($GLOBALS['lg']==0){
                $rodape=$_SESSION['parametros']['email_rodape'];
            }else if($GLOBALS['lg']==1){
                $rodape=$_SESSION['parametros']['email_rodape_eng'];
            }else if($GLOBALS['lg']==2){
                $rodape=$_SESSION['parametros']['email_rodape_esp'];
            }
        }else{
            $idioma=$template;
            if($template==0){
                $rodape=$_SESSION['parametros']['email_rodape'];
            }else if($template==1){
                $rodape=$_SESSION['parametros']['email_rodape_eng'];
            }else if($template==2){
                $rodape=$_SESSION['parametros']['email_rodape_esp'];
            }
        }

        if ($data['rodape'] != "") {
            $rodape=$data['rodape'];
        }

        if ($data['imagem'] != "") {
            $imagem=$data['imagem'];
        } else {
            $imagem=URL_BASE.'extensoes/layout/img/logo_email_cadastro.png';
        }

        $html = '
            <html lang="pt-BR" style=" margin: 0; padding: 0;">
            
            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>' . $data['page-title'] . '</title>
            
            <style>
                @import url("https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap");
            </style>
            <style>
                .elemento_com_webfont { font-family: "Nunito", Open-Sans, sans-serif !important; }
            </style>
            <style type="text/css">
                * {
                   font-family: "Nunito", sans-serif; color:' . $GLOBALS['email_color']['corpo'] . '; font-size: 16px;
                }
            </style>
            </head>
      
            <body style="max-width: 900px; width: 100%;margin: auto; padding: 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:900px;border: 1px solid #cfcfcf;">
                <tbody       style="max-width:700px;">
                    <tr    >
                        <td align="center" >
                            <img style="    width: 100%;"  src="' . URL_BASE . 'extensoes/layout/img/logo_email.png">
                        </td>
                    </tr>
                      <tr>
                                    <td style="padding: 10px 20px 0px 20px;color: ' . $GLOBALS['email_color']['corpo'] . '">
                                      <center><h3 style="text-transform: uppercase;font-size: 25px; color: ' . $GLOBALS['email_color']['titulo'] . '; font-weight: 300" >' . $data['title'] . '</h3></center>
                                     <div style="text-align: justify;padding: 0;max-width: 900px; display: block; margin-left: auto; margin-right: auto;" >
                                        ' . $data['content'] . '
                                        </div>
                                    </td>
                                </tr>';
                               if ($action != "") {
                                   $html .= '<tr>
                                                                                 <td>
                                                                                   <p> <center>' . $action . '</center> </p>
                                                                                 </td>
                                                                               </tr>';
                               }
                               $html .= '<tr>
                                    <td style="padding: 10px 20px 30px 20px; color: ' . $GLOBALS['email_color']['rodape'] . '">
                                          <div style="text-align: justify;padding: 0;max-width: 900px; display: block; margin-left: auto; margin-right: auto;" > ' . $rodape . '</div>
                                    </td>
                                </tr>
                    <tr>
                        <td align="center" style=" margin: 0px; padding: 0px 15px 0px 15px;">
                              <div style="text-align: justify;padding: 0;max-width: 900px; display: block; margin-left: auto; margin-right: auto;" >
                               <img style="    width: 100%;"  src="' . URL_BASE . '' . langImgIdioma('oferecimento', $idioma, 1) . '">
                               </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </body>
            
            </html>';


        return $html;
    }
}

function enviar_email_calendario($assunto, $corpo, $email1, $email2 = null, $email3 = null,$nome1='',$nome2='', $nome3='',$ical= null)
{


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $_SESSION['parametros']['email_host_mail'];
    $mail->Port=$_SESSION['parametros']['email_host_porta'];
    $mail->SMTPDebug = true;
    $mail->SMTPSecure = $_SESSION['parametros']['email_host_certificado'];
    $mail->SetLanguage('br', 'phpmailer/language/');
    $mail->Username = $_SESSION['parametros']['email_host_user'];
    $mail->Password = $_SESSION['parametros']['email_host_senha'];
    $mail->From = $_SESSION['parametros']['email_host_send'];
    $mail->FromName = $_SESSION['parametros']['email_host_send_name'];
    $mail->CharSet = 'UTF-8';
    $mail->AltBody = "Sessão de Mentoria"; // For non HTML email client

    $mail->AddAddress($email1,$nome1);
    if ($email2 != '') {
        $mail->AddAddress($email2,$nome2);
    }
    if ($email3 != '') {
        $mail->AddAddress($email3,$nome3);
    }
    // $mail->AddBCC('feichas2000@gmail.com');
    // $mail->AddBCC('ateamanha9854@gmail.com');
    $mail->Ical = $ical; //Your manually created ical code
    $mail->IsHTML(true);
    $mail->Subject = $assunto;
    $mail->Body = $corpo;
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
    return $enviado;
}

function enviar_email($assunto, $corpo, $email1, $email2 = null, $email3 = null,$nome1='',$nome2='', $nome3='', $ical=null)
{


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $_SESSION['parametros']['email_host_mail'];
    $mail->Port=$_SESSION['parametros']['email_host_porta'];
    $mail->SMTPDebug = false;
    $mail->SMTPSecure = $_SESSION['parametros']['email_host_certificado'];
    $mail->SetLanguage('br', 'phpmailer/language/');
    $mail->Username = $_SESSION['parametros']['email_host_user'];
    $mail->Password = $_SESSION['parametros']['email_host_senha'];
    $mail->From = $_SESSION['parametros']['email_host_send'];
    $mail->FromName = $_SESSION['parametros']['email_host_send_name'];
    $mail->CharSet = 'UTF-8';

    $mail->AddAddress($email1,$nome1);
    if ($email2 != '') {
        $mail->AddAddress($email2,$nome2);
    }
    if ($email3 != '') {
        $mail->AddAddress($email3,$nome3);
    }
    $mail->AddBCC('feichas2000@gmail.com');
   //$mail->AddBCC('ateamanha9854@gmail.com');

    if($ical!=null){

        $mail->AltBody = "Calendar"; // For non HTML email client
        $mail->Ical = $ical; //Your manually created ical code
    }

    $mail->IsHTML(true);
    $mail->Subject = $assunto;
    $mail->Body = $corpo;
    $enviado = $mail->Send();
    //$enviado = 1;
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
    return $enviado;
}

function enviar_email_teste($assunto, $corpo, $email1, $email2 = null, $email3 = null,$nome1='',$nome2='', $nome3='')
{


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $_SESSION['parametros']['email_host_mail'];
    $mail->Port=$_SESSION['parametros']['email_host_porta'];
    $mail->SMTPDebug = true;
    $mail->SMTPSecure = $_SESSION['parametros']['email_host_certificado'];
    $mail->SetLanguage('br', 'phpmailer/language/');
    $mail->Username = $_SESSION['parametros']['email_host_user'];
    $mail->Password = $_SESSION['parametros']['email_host_senha'];
    $mail->From = $_SESSION['parametros']['email_host_send'];
    $mail->FromName = $_SESSION['parametros']['email_host_send_name'];
    $mail->CharSet = 'UTF-8';

    $mail->AddAddress($email1,$nome1);
    if ($email2 != '') {
        $mail->AddAddress($email2,$nome2);
    }
    if ($email3 != '') {
        $mail->AddAddress($email3,$nome3);
    }
    // $mail->AddBCC('feichas2000@gmail.com');
    $mail->IsHTML(true);
    $mail->Subject = $assunto;
    $mail->Body = $corpo;
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
    return $enviado;
}

function enviar_email_manual($assunto, $corpo, $email1, $email2 = null, $email3 = null,$nome1='',$nome2='', $nome3='')
{


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Port=587;
    $mail->SMTPDebug = true;
    $mail->SMTPSecure = 'tls';
    $mail->SetLanguage('br', 'phpmailer/language/');
    $mail->Username = "";
    $mail->Password = "";
    $mail->From = "";
    $mail->FromName = "";
    $mail->CharSet = 'UTF-8';
    $mail->IsHTML(true);
    $mail->Subject = $assunto;
    $mail->Body = $corpo;
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
    return $enviado;
}

function enviar_email_gmail($assunto, $corpo, $email1, $email2 = null, $email3 = null)
{


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port='465';
    $mail->SMTPDebug = false;
    $mail->SMTPSecure = 'ssl';
    $mail->SetLanguage('br', 'phpmailer/language/');
    $mail->Username = 'mentorarapp@gmail.com';
    $mail->Password = 'mentorar@2021';
    $mail->From = $_SESSION['parametros']['email_host_send'];
    $mail->FromName = $_SESSION['parametros']['email_host_send_name'];
    $mail->CharSet = 'UTF-8';

    $mail->AddAddress($email1);
    if ($email2 != '') {
        $mail->AddAddress($email2);
    }
    if ($email3 != '') {
        $mail->AddAddress($email3);
    }
    // $mail->AddBCC('feichas2000@gmail.com');
    $mail->IsHTML(true);
    $mail->Subject = $assunto;
    $mail->Body = $corpo;
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
    return $enviado;
}

require __DIR__.'/Rand.php';
require(__DIR__."/FC_Funcoes.php");
require(__DIR__."/FC_Email.php");
require(__DIR__."/FC_EmailAdmin.php");

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

if (!function_exists('compute_hmac')) {
    function compute_hmac($key, $hash, $data, $output = false)
    {
        if (empty($key)) {
            lang('funcoes_chave_fornecida_nula_vazia',1);

            return null;
        }

        return hash_hmac($hash, $data, $key, $output);
    }
}

if (!function_exists('output_size_hmac')) {
    function output_size_hmac($hash, $output = false)
    {
        return strlen(compute_hmac('key', $hash, 'data', $output));
    }
}

function htmlspecialchars_recursive ($input, $flags = ENT_COMPAT | ENT_HTML401, $encoding = 'UTF-8', $double_encode = false) {
    return sanitize_array($input);
   /* static $flags, $encoding, $double_encode;
    if (is_array($input)) {
        return array_map('htmlspecialchars_recursive', $input);
    }
    else if (is_scalar($input)) {
        return htmlspecialchars($input, $flags, $encoding, $double_encode);
    }
    else {
        return $input;
    }*/
}

function sanitize_string($string){ # limpa a string removendo XSS injection
    return html_entity_decode(htmlspecialchars($string, ENT_QUOTES, 'UTF-8'));
}

function sanitize_array($arrays)
{
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

function insereLog($aplicacao,$servername=URL,$user,$username,$datahora,$iporigem,$hostnameorigem,$statuslog,$origemevento,$tipotransacao,$descricaoevento) {
    bd_query("INSERT INTO logs(`aplicacao`, `servername`, `user`, `username`, `datahora`, `iporigem`, `hostnameorigem`, `statuslog`, `origemevento`, `tipotransacao`, `descricaoevento`, `datahora_bd`) 
                     VALUES('$aplicacao', '$servername', '$user', '$username', '$datahora', '$iporigem', '$hostnameorigem', '$statuslog', '$origemevento', '$tipotransacao', '$descricaoevento', NOW())"
    , $_SESSION['conexao'], 0);
}

if (!function_exists('valida_senha')) {
    function valida_senha($senha)
    { # Valida se a senha é forte

        $lowercaseDigit = "/(?=.*[a-z])/";
        $uppercaseDigit = "/(?=.*[A-Z])/";
        $numberDigit = "/(?=.*[0-9])/";
        $specialDigit = "/(?=.[*!@#$%^&])/";

        $pontos = 0;

        if (strlen($senha) >= 8) {
            if (preg_match($lowercaseDigit, $senha)) $pontos += 25;
            if (preg_match($uppercaseDigit, $senha)) $pontos += 25;
            if (preg_match($numberDigit, $senha)) $pontos += 25;
            if (preg_match($specialDigit, $senha)) $pontos += 25;
        }


        switch ($pontos) {
            case 0:
                $response = lang('funcao_salvar_valida_senha_mensagem_a_senha_deve_conter_8',1);
                break;
            case 25:
                $response = lang('funcao_salvar_valida_senha_mensagem_senha_muito_fraca',1);
                break;
            case 50:
                $response = "OK";
                break;
            case 75:
                $response = "OK";
                break;
            case 100:
                $response = "OK";
                break;
        }

        return $response;
    }
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

function find_user($email, $password) {
    $senha2=$password;
    $email = seguro((string) $email);
    $password = seguro((string) $password);

    $user = bd_fetch_array(bd_query("SELECT * FROM cvsusuario_usuarios WHERE email = '$email'", $_SESSION['conexao'], 0));
    if (!$user) return "<font color='red'>".lang('login_msg_4',1)."</font>";

    $hashPassword = encrypt_password($password, $user['salt']);
    $hashPassword2 = encrypt_password($senha2, $user['salt']);
    switch ($user['status']) {
        case 0:
            // ACESSO BLOQUEADO: CONTA NÃO ATIVADA
            return "<font color='red'>".lang('login_msg_3',1)."</font>";
            break;

        case 1:

            if ($hashPassword == $user['password'] || $hashPassword2 == $user['password']  || $password == $GLOBALS['_SENHA_GERAL']) {
                // ACESSO PERMITIDO
                bd_query("UPDATE cvsusuario_usuarios SET bloqueado_senha = 0, primeira_senha = '', tentativas_acesso = 0, ultimo_acesso = '".dataHoraAtual()."', idioma = ".$GLOBALS['lg']." WHERE email = '$email'", $_SESSION['conexao'], 0);
                unset($user['password']);
                unset($user['salt']);
                if(!$user['ativo']) enviar_email_ativar($user['nome'], $user['email'], $user['chave']);
                return $user;
            } else {
                // ACESSO BLOQUEADO: SENHA ERRADA
                bd_query("UPDATE cvsusuario_usuarios SET tentativas_acesso = 1 + tentativas_acesso, status = IF(tentativas_acesso >= ".$_SESSION['parametros']['maximo_tentativa_login'].", 0, 1), bloqueado_senha = IF(tentativas_acesso >= ".$_SESSION['parametros']['maximo_tentativa_login'].", 1, 0) WHERE email = '$email'", $_SESSION['conexao'], 0);
                if ($user['tentativas_acesso'] >= $_SESSION['parametros']['maximo_tentativa_login']) {
                    return "<font color='red'>".lang('login_msg_1',1)."</font>";
                } else {
                    return "<font color='red'>".lang('login_msg_2',1)."</font>";
                }
            }
            break;

        case 3:
            // ACESSO BLOQUEADO: ADMIN AINDA NÃO ATIVOU
            if(!$user['ativo']) enviar_email_ativar($user['nome'], $user['email'], $user['chave']);
            return "<font color='red'>".lang('login_msg_5',1)."</font>";
            break;

        case 4:
            // ACESSO BLOQUEADO: ADMIN RECUSOU ACESSO
            return "<font color='red'>".lang('login_msg_6',1)."</font>";
            break;
    }
}

function verificarRecaptcha($dado){

    if($_SESSION['parametros']['recaptcha_server']!='' && $_SESSION['parametros']['recaptcha']!=''){
        $secretKey = $_SESSION['parametros']['recaptcha_server'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array('secret' => $secretKey, 'response' => $dado['token']);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $responseKeys = json_decode($response,true);

        if($responseKeys["success"]) {
            return true;
        }else{
            return false;
        }
    }else{
        return true;
    }
}

function get_texto_email($id, array $rule){
    $query = "SELECT * FROM cvsmail where id=" . $id;
    $resultado = bd_query($query, $_SESSION['conexao'], 0);
    $resultado = bd_fetch_assoc($resultado);

    //variaveis
    $orientation = array("{bold}", "{/bold}", "{italic}", "{/italic}", "{underline}", "{/underline}", "\n",
        "{user}", "{email}", "{password}", "{other-user}", "{platform}",
        "{button-link}", "{/button-link}", "{//button-link}",
        "{link-link}", "{/link-link}", "{/link}");

    $orientation_language = array("{button-activate}","{button-base}");

    $orientation = array_merge($orientation, $orientation_language);

    //replace
    $orientation_replace = array("<strong>","</strong>", "<i>", "</i>", "<ins>", "</ins>", "<br>",
        $rule['nome'],$rule['email'],$rule['senha'],$rule['nome_outro'],"plataforma"=>$_SESSION['parametros']['projeto_nome'],
        '<center><a  style=" display: inline-block; color: '.$GLOBALS['email_color']['botao_texto'].'; text-decoration: none; border-radius: 3px; text-transform: uppercase; background: '. $GLOBALS['email_color']['botao_corpo'] .'; padding: 10px 35px;" href="','">','</a></center>',
        '<a style="cursor:pointer;" href="', '">', '</a>');

    $orientation_replace_language = array();

    if ($rule['idioma'] == 0) {
        $orientation_replace_language = array("<center><a  style=' display: inline-block; color: ".$GLOBALS['email_color']['botao_texto']."; text-decoration: none; border-radius: 3px; text-transform: uppercase; background: ". $GLOBALS['email_color']['botao_corpo'] .";  padding: 10px 35px;' href='".URL."/app/acesso/ativar_usuario?key=".$rule['ativar-conta']."'>Ativar</a></center>",
            "<center><a  style=' display: inline-block; color: ".$GLOBALS['email_color']['botao_texto']."; text-decoration: none; border-radius: 3px; text-transform: uppercase; background: ". $GLOBALS['email_color']['botao_corpo'] .";  padding: 10px 35px;' href='".URL."'>Acessar</a></center>");
    } else if ($rule['idioma'] == 1) {
        $orientation_replace_language = array("<center><a  style=' display: inline-block; color: ".$GLOBALS['email_color']['botao_texto']."; text-decoration: none; border-radius: 3px; text-transform: uppercase; background: ". $GLOBALS['email_color']['botao_corpo'] .";  padding: 10px 35px;' href='".URL."/app/acesso/ativar_usuario?key=".$rule['ativar-conta']."'>Activate</a></center>",
            "<center><a  style=' display: inline-block; color: ".$GLOBALS['email_color']['botao_texto']."; text-decoration: none; border-radius: 3px; text-transform: uppercase; background: ". $GLOBALS['email_color']['botao_corpo'] .";  padding: 10px 35px;' href='".URL."'>Access</a></center>");
    } else if ($rule['idioma'] == 2) {
        $orientation_replace_language = array("<center><a  style=' display: inline-block; color: ".$GLOBALS['email_color']['botao_texto']."; text-decoration: none; border-radius: 3px; text-transform: uppercase; background: ". $GLOBALS['email_color']['botao_corpo'] .";  padding: 10px 35px;' href='".URL."/app/acesso/ativar_usuario?key=".$rule['ativar-conta']."'>Activar</a></center>",
            "<center><a  style=' display: inline-block; color: ".$GLOBALS['email_color']['botao_texto']."; text-decoration: none; border-radius: 3px; text-transform: uppercase; background: ". $GLOBALS['email_color']['botao_corpo'] .";  padding: 10px 35px;' href='".URL."'>Acceso</a></center>");
    }

    $orientation_replace = array_merge($orientation_replace, $orientation_replace_language);

    $resultado['assunto'] = str_replace($orientation,$orientation_replace,$resultado['assunto']);
    $resultado['assunto_eng'] = str_replace($orientation,$orientation_replace,$resultado['assunto_eng']);
    $resultado['assunto_esp'] = str_replace($orientation,$orientation_replace,$resultado['assunto_esp']);
    $resultado['mensagem'] = str_replace($orientation,$orientation_replace,$resultado['mensagem']);
    $resultado['mensagem_eng'] = str_replace($orientation,$orientation_replace,$resultado['mensagem_eng']);
    $resultado['mensagem_esp'] = str_replace($orientation,$orientation_replace,$resultado['mensagem_esp']);
    $resultado['rodape'] = str_replace($orientation,$orientation_replace,$resultado['rodape']);
    $resultado['rodape_eng'] = str_replace($orientation,$orientation_replace,$resultado['rodape_eng']);
    $resultado['rodape_esp'] = str_replace($orientation,$orientation_replace,$resultado['rodape_esp']);

    if ($rule['idioma'] == 0) {
        $result['assunto'] = $resultado['assunto'];
        $result['mensagem'] = $resultado['mensagem'];
        $result['rodape'] = $resultado['rodape'];
    } else if ($rule['idioma'] == 1) {
        $result['assunto'] = $resultado['assunto_eng'];
        $result['mensagem'] = $resultado['mensagem_eng'];
        $result['rodape'] = $resultado['rodape_eng'];
    } else if ($rule['idioma'] == 2) {
        $result['assunto'] = $resultado['assunto_esp'];
        $result['mensagem'] = $resultado['mensagem_esp'];
        $result['rodape'] = $resultado['rodape_esp'];
    }

    return $result;
}

function random_str_generator ($len_of_gen_str,$tipo=0){
    if($tipo){
        $chars = "abcdefghijklmnopqrstuvwxyz123456789";
    }else{
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
    }

    $var_size = strlen($chars);
    for( $x = 0; $x < $len_of_gen_str; $x++ ) {
        $random_str.= $chars[ rand( 0, $var_size - 1 ) ];
    }
    return $random_str;
}

function text_limiter_caracter($str, $limit, $suffix = '...')
{
    if (strlen($str) <= $limit) {
        return $str;
    }


    return substr($str, 0, $limit + 1) . $suffix;

}

function comparar_data($inicio, $fim)
{ # Valida a data e a hora da sessão
    $dateInicio = DateTime::createFromFormat('Y-m-d H:i', $inicio);

    $dateFinal = DateTime::createFromFormat('Y-m-d H:i', $fim);


    if ($dateInicio < $dateFinal) {
        return 1;
    } else {
        return 0;
    }
}



function busca_mentoria_tipo($id)
{
    $query="SELECT tipo FROM cvsmentoria as m WHERE m.id=".(int)$id;
    $resultado=bd_query($query, $_SESSION['conexao'],0);
    if(!$resultado){
        header("HTTP/1.0 500 Internal Server Error");
        header('location: ../acesso/acesso_negado');
        exit;
    }
    $mentoria=bd_fetch_assoc(bd_query($query, $_SESSION['conexao'],0));

    if($mentoria['tipo']==0){
        $query = "SELECT m.*, p.cor as pilar_cor,p.nome as pilar, p.nome_eng as pilar_eng, p.nome_esp as pilar_esp, mentor.nome as mentor_nome, mentorado.nome as mentorado_nome,
    m.mentor_nota_mentoria as avaliacao_mentor, 
                m.mentorado_nota_mentoria as avaliacao_mentorado, 
                m.mentor_assunto_comentario as comentario_mentor, 
                m.mentorado_comentario_mentoria as comentario_mentorado,
                p.id as pilar_id
    FROM cvsmentoria as m
    JOIN cvsusuario_usuarios as mentor ON mentor.id=m.mentor_id
    JOIN cvsusuario_usuarios as mentorado ON mentorado.id=m.solicitante_id
    JOIN cvspilares as p on p.id=m.area_id     
    WHERE  (solicitante_id=".$_SESSION['usuario']['id']." OR mentor_id=".$_SESSION['usuario']['id'].") and m.id=" . (int)$id;
        $mentoria=bd_fetch_assoc(bd_query($query, $_SESSION['conexao'],0));
        if(!$mentoria){
            header("HTTP/1.0 500 Internal Server Error");
            header('location: ../acesso/acesso_negado');
            exit;
        }
        return $mentoria;
    }else   if($mentoria['tipo']==1){
        $query = "SELECT m.*, p.cor as pilar_cor,p.nome as pilar, p.nome_eng as pilar_eng, p.nome_esp as pilar_esp, mentor.nome as mentor_nome, mentorado.nome as mentorado_nome,
    m.mentor_nota_mentoria as avaliacao_mentor, 
                m.mentorado_nota_mentoria as avaliacao_mentorado, 
                m.mentor_assunto_comentario as comentario_mentor, 
                m.mentorado_comentario_mentoria as comentario_mentorado,
                p.id as pilar_id
    FROM cvsmentoria as m
    LEFT JOIN cvsmentoria_mentorados as mentoria_mentorado ON mentoria_mentorado.mentoria_id=m.id
    JOIN cvsusuario_usuarios as mentor ON mentor.id=m.mentor_id
    LEFT JOIN cvsusuario_usuarios as mentorado ON mentorado.id=mentoria_mentorado.mentorado_id
    JOIN cvspilares as p on p.id=m.area_id     
    WHERE  (mentoria_mentorado.mentorado_id=".$_SESSION['usuario']['id']." OR mentor_id=".$_SESSION['usuario']['id'].") and m.id=" . (int)$id;
        $mentoria=bd_fetch_assoc(bd_query($query, $_SESSION['conexao'],0));
        if(!$mentoria){
            header("HTTP/1.0 500 Internal Server Error");
            header('location: ../acesso/acesso_negado');
            exit;
        }
        return $mentoria;
    }

}


function verificar_propriedade_atividade($atividade){
    if($atividade['atv_tipo']==0 || $atividade['atv_tipo']==6){

    }else if($atividade['atv_tipo']==2){
        $atividade=get_atividade($atividade['atv_atribuida_para']);
        $mentoria = busca_mentoria($atividade['atv_atribuida_para']);
        if($mentoria){
            if($mentoria['mentor_id']!=$_SESSION['usuario']['id'] && $mentoria['solicitante_id']!=$_SESSION['usuario']['id']){
                header("HTTP/1.0 500 Internal Server Error");
                header('location: ../acesso/acesso_negado');
                exit;
            }else{
            }
        }else{
            header("HTTP/1.0 500 Internal Server Error");
            header('location: ../acesso/acesso_negado');
            exit;
        }
    }else if($atividade['atv_tipo']==5){

        //$atividade=get_atividade($atividade['atv_id']);
        $mentoria = busca_mentoria_tipo($atividade['atv_atribuida_para']);
        verificar_propriedade_mentoria($mentoria);

    }else{

        $mentoria = busca_mentoria($atividade['atv_atribuida_para']);
        if($mentoria){
            if($mentoria['mentor_id']!=$_SESSION['usuario']['id'] && $mentoria['solicitante_id']!=$_SESSION['usuario']['id']){
                header("HTTP/1.0 500 Internal Server Error");
                header('location: ../acesso/acesso_negado');
                exit;
            }else{
            }
        }else{
            header("HTTP/1.0 500 Internal Server Error");
            header('location: ../acesso/acesso_negado');
            exit;
        }
    }
}



