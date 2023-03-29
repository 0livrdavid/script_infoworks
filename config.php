<?php
$GLOBALS['_SENHA_GERAL'] = "infoworks";
$GLOBALS['_SENHA_GERAL'] = "infoworks";

$flagError=true;
if($flagError){
    ini_set('error_reporting', E_ALL); // mesmo resultado de: error_reporting(E_ALL);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}else{
    ini_set('error_reporting', 0); // mesmo resultado de: error_reporting(E_ALL);
    ini_set('display_errors', 0);
    error_reporting(0);
}

ob_start();
session_cache_expire(525600);
error_reporting(0);
ini_set('session.gc_maxlifetime', 10800);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
session_name(md5("seg".$_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"]));
session_start();

header("X-XSS-Protection: 1");
header('X-Frame-Options: deny');
header("Strict-Transport-Security:max-age=63072000");
header("X-Content-Type-Options: nosniff");
define("URL", "http://infoworks.site");
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != URL)
{
    echo "Acesso negado";die;
}

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], URL ))
{
    echo "Acesso negado";die;
}

ini_set("display_errors", 1);
$ip_host = $_SERVER['REMOTE_ADDR'];
$_SESSION['MOSTRA'] = 0;

$ref = $_SERVER['HTTP_REFERER'];
$refData = parse_url($ref);


if($_SESSION["token"]==''){
    $_SESSION["token"] = md5(uniqid(mt_rand(), true));
}

define("PATH", "/");

define('CWD', getcwd());

define("URL_BASE", URL."/");
define("URL_BASE_LAYOUT", URL_BASE."layout/");
define("URL_BASE_APP", URL_BASE."app/");
define("URL_BASE_ASSETS_CSS", URL_BASE."src/css/");
define("PATH_ASSETS_CSS", PATH."src/css/");
define("URL_BASE_ASSETS_JAVASCRIPT", URL_BASE."src/js/");
define("PATH_ASSETS_JAVASCRIPT", PATH."src/js/");
define("URL_BASE_ASSETS_PICTURES", URL_BASE."src/pictures/");
define("PATH_ASSETS_PICTURES", PATH."src/pictures/");

define("PATH_ASSETS_END", "../../layout/end.php");

$_SESSION['url_site']=URL_BASE;

// BASE DE DADOS
$_SESSION['database_desc'] = 'Produção';
$_SESSION['database_vers'] = '001';
$database_server = '127.0.0.1';
$database_type = 'mysql';
$database_username = 'root';
$database_password = '';
$database_name = 'faculdade_infoworks';
$database_port = '0';

require_once 'functions/FC_FuncoesBD.php';
require_once 'functions/FC_Sistema.php';