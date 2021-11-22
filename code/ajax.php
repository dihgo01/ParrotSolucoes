<?php

if (!isset($_SESSION)) {
    session_start(); 
}

include_once '../variaveis-aplicacao.php';
include_once 'classes-web.class.php';
include_once 'functions.php';


$classesWeb = new ClassesWeb();

if (isset($_GET['action_type'])) {
    $acao = trim($_GET['action_type']);
} else {
    $acao = trim($_POST['action_type']);
}

if($acao === 'login')
{
    if(isset($_POST['email']) && isset($_POST['senha']))
    {
        $email = mb_strtolower($_POST['email'], 'UTF-8');
        $senha = $_POST['senha'];
        $query = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";

        $consulta = $classesWeb->get_query_unica($query);

        if(isset($consulta->senha))
        {

            if(password_verify($senha, $consulta->senha))
            {
                $search_user = $classesWeb->busca_usuario_login($email, $consulta->senha);
                if(!empty($search_user))
                {
                    $_SESSION['usuario'] = array(
                        'SESS_USER_HASH' => $consulta->hash, 
                        'SESS_USER_NAME' => $consulta->nome_completo, 
                        'SESS_USER_EMAIL' => $consulta->email, 
                        'SESS_USER_HIERARQUIA' => $consulta->hierarquia);
                    echo json_encode(array(
                        'status' => 'OK',
                        'message' => 'Login realizado com sucesso',
                        'type' => 'redirect',
                        'url' => WEBURL . 'home'
                        ));
                } 
                else 
                {
                    echo json_encode(array(
                        'status' => 'Erro', 
                        'message' => 'Falha no login.', 
                        'type' => 'close'));
                }
            } 
            else 
            {
                echo json_encode(array('status' => 'Erro', 'message' => 'Senha incorreta.'));
            }
        } 
        else 
        {
            echo json_encode (array('status' => 'Erro', 'message' => 'Usuário não cadastrado.'));
        }
    } 
    else 
    {
        echo json_encode (array('status' => 'Erro', 'message' => 'Preencha todos os campos para entrar.'));
    }
    
}

if ($acao === 'excluir_item') {
    $campos = array('status');
    for ($i = 0; $i < (int) sizeof($campos); $i++) {
        $campos[$i] = $campos[$i] . ' = ?';
    }
    $valores = array('Inativo');
    $update = $classesWeb->query_update(implode(', ', $campos), $valores, $_POST['table'], $_POST['parameter'] . ' = "' . $_POST['key'] . '"');
    if ((int) $update > 0) {
        echo json_encode(array(
            'status' => 'OK',
            'message' => 'Item excluído com sucesso',
            'type' => ''
        ));
    } else {
        echo json_encode(array(
            'status' => 'ERROR',
            'message' => 'Ocorreu um erro durante o processo. Tente novamente.',
            'type' => 'close'
        ));
    }
}   
