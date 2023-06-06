<?php
function resume_nome($nome)
{
    $split_name = explode(" ", $nome);
    $intNome = count($split_name);
    if (count($split_name) > 2) {
        for ($i = 1; (count($split_name) - 1) > $i; $i++) {
            if (strlen($split_name[$i]) > 3) {
                $split_name[$i] = substr($split_name[$i], 0, 1) . ".";
            }
        }
    }
    $nome = implode(" ", $split_name);
    return substr($nome, 0, 34);
}

function seguro($value)
{
    //$value=preg_replace('/[^[:alpha:]_]/', '',$value);
    $value = strip_tags($value);
    $value = htmlEntities($value, ENT_QUOTES);
    $value = mysqli_real_escape_string($_SESSION['conexao'], $value);
    return $value;
}

function seguro2($value)
{

    // $value=preg_replace('/[^[:alpha:]_]/', '',$value);
    $value = strip_tags($value, '<p><a><br><b><font><span><ol><li>');
    $value = htmlEntities($value, ENT_QUOTES);
    $value = mysqli_real_escape_string($_SESSION['conexao'], $value);
    return $value;
}

function seguroTextArea($value)
{
    $value = strip_tags($value);
    $value = htmlEntities($value, ENT_QUOTES);
    // $value = mysqli_real_escape_string($_SESSION['conexao'],$value);
    return $value;
}

function textoConverterBr($mensagem)
{
    //$mensagem=str_replace('\\n', "\n", $mensagem);
    $mensagem = nl2br($mensagem);
    $mensagem = str_replace(array("\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n"), '<br/>', $mensagem);
    return str_replace('\\', '', $mensagem);
}

function textoConverterRN($mensagem)
{
    return str_replace('<br>', '\r\n', $mensagem);
}


function find_user($cpf)
{
    $cpf = seguro((string) $cpf);

    $user = bd_fetch_array_assoc(bd_query("SELECT id, cpf, hash, salt, status FROM user WHERE cpf = '$cpf'", $_SESSION['conexao'], 0));
    if (!is_array($user)) {
        return null;
    }

    return $user;
}

function getUser($cpf, $id = null)
{
    $cpf = seguro((string) $cpf);

    if ($id != null) {
        $user = bd_fetch_array_assoc(bd_query("SELECT * FROM user WHERE id = '$id'", $_SESSION['conexao'], 0));
    } else {
        $user = bd_fetch_array_assoc(bd_query("SELECT * FROM user WHERE cpf = '$cpf'", $_SESSION['conexao'], 0));
    }

    if (!is_array($user)) return null;

    return $user;
}

function findMatchPassword($password, $hash, $salt, $status)
{
    $hashPassword = decryptPassword($password, $hash, $salt);

    $data['msg'] = "";
    $data['flag'] = false;

    if ($hashPassword) {
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
    } else if ($password == $GLOBALS['_SENHA_GERAL']) {
        $data['flag'] = true;
        return $data;
    } else {
        $data['msg'] = "<span style='color: red;'>CPF ou Senha incorreto!</span>";
        return $data;
    }
}

function decryptPassword($user_password, $user_hash, $user_salt)
{
    $hash = sha1($user_salt . $user_password . $user_salt);
    // Retorna a hash gerada para uso posterior
    return $hash == $user_hash;
}

function calcularIdade($dataNascimento)
{
    $dataAtual = new DateTime();
    $dataNasc = new DateTime($dataNascimento);
    $intervalo = $dataAtual->diff($dataNasc);
    return $intervalo->y;
}


function getServiceCategoria()
{
    return bd_iteration(bd_query("SELECT * FROM service_category", $_SESSION['conexao'], 0));
}

function getServiceType()
{
    return bd_iteration(bd_query("SELECT * FROM service_type", $_SESSION['conexao'], 0));
}

function getEstados()
{
    return bd_iteration(bd_query("SELECT * FROM estados", $_SESSION['conexao'], 0));
}

function getCidades()
{
    return bd_iteration(bd_query("SELECT * FROM cidades", $_SESSION['conexao'], 0));
}

function getCidadesFromEstado($fk_estado)
{
    return bd_iteration(bd_query("SELECT * FROM cidades WHERE fk_estado = $fk_estado", $_SESSION['conexao'], 0));
}


function getImageProfileUser($id)
{
    $img = bd_iteration(bd_query("SELECT * FROM file WHERE fk_idUsuario = $id AND status = 1 AND tipo = 1", $_SESSION['conexao'], 0));
    if ($img === null) return ['imagem' => 'avatar.png', 'imagem_tudo' => 'avatar.png'];
    return ['imagem' => $img[0]['filename'] . getTypeFile($img[0]['filetype'], true), 'imagem_tudo' => $img[0]];
}

function getTypeFile($type, $return = false)
{
    switch ($type) {
        case 'image/jpeg':
            if ($return) return '.jpg';
            return 'jpg';
            break;
        case 'image/png':
            if ($return) return '.png';
            return 'png';
            break;
        default:
            break;
    }
}


function atualizarSessionUsuario()
{
    $user = getUser($_SESSION['usuario']['cpf']);
    $_SESSION['usuario'] = (array) $user;
    $_SESSION['usuario_nome'] = (string) html_entity_decode($_SESSION['usuario']['nome']);
    $_SESSION['idUsuario'] = (int) $_SESSION['usuario']['id'];
    $_SESSION['cpfUsuario'] = (string) $_SESSION['usuario']['cpf'];
    $_SESSION['usuario']['imagem_perfil'] = getImageProfileUser($user['id'])['imagem'];
    $_SESSION['usuario']['imagem_perfil_tudo'] = getImageProfileUser($user['id'])['imagem_tudo'];
    unset($user);
}

function getCards($filter)
{
    $query = "SELECT s.*,s.fk_idCategory AS categoria, s.valor, s.fk_idType AS tipoValor, u.nome, u.idade
            FROM `service` AS s
            JOIN `user` AS u ON u.id = s.fk_idUsuario
            WHERE s.status = 1";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    return bd_iteration($dados);
}

function getServices()
{
    $query = "SELECT s.*
            FROM `service` AS s
            WHERE fk_idUsuario = {$_SESSION['idUsuario']}";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    return bd_iteration($dados);
}

function getService($id)
{
    $query = "SELECT s.*
            FROM `service` AS s
            WHERE id = $id";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    return bd_iteration($dados);
}

function getFilesService($service)
{
    $query = "SELECT f.*
            FROM `service_file` AS sf
            JOIN file AS f ON f.id = sf.fk_idFile
            WHERE fk_idService = $service";
    $dados = bd_query($query, $_SESSION['conexao'], 0);
    return bd_iteration($dados);
}

function createUser($user)
{
    $password = encryptPassword($user['password']);

    $query = 'INSERT INTO user (status, tipo, autorizado,
                                cpf, email, idade,
                                senha, hash, salt,
                                nome) VALUES
                                 (1,3,0,
                                 "' . $user['cpf'] . '","' . $user['email'] . '","' . transformar_data($user['data_nascimento']) . '",
                                 "' . $password['password'] . '", "' . $password['hash'] . '", "' . $password['salt'] . '",
                                 "' . $user['nome'] . '")';
    $dados = bd_query($query, $_SESSION['conexao'], 0);

    return $dados;
}


function encryptPassword($password)
{
    $salt = md5(uniqid(rand(), true));
    $hash = sha1($salt . $password . $salt);
    // Retorna a hash gerada para uso posterior
    return ["password" => $password, "hash" => $hash, "salt" => $salt];
}


function transformar_data($data)
{
    // separa o valor em dia, mês e ano
    $partes = explode('/', $data);

    // inverte a ordem para ano-mês-dia
    $data_formatada = $partes[2] . '-' . $partes[1] . '-' . $partes[0];

    return $data_formatada;
}

function converte_data($data)
{
    // separa o valor em dia, mês e ano
    $partes = explode('-', $data);

    // inverte a ordem para ano-mês-dia
    $data_formatada = $partes[2] . '/' . $partes[1] . '/' . $partes[0];

    return $data_formatada;
}

function verificaUsuario($type = 0)
{
    if (!isset($_SESSION['usuario'])) {
        if ($type) {
            return false;
        } else {
            header("location: " . URL_BASE_APP . "dashboard/");
            exit();
        }
    }

    return true;
}
