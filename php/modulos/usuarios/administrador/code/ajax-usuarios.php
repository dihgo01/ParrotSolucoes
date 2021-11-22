<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/variaveis-aplicacao.php';
include_once ROOT . 'code/classes-web.class.php';
include_once ROOT . 'code/functions.php';
$classesWeb = new ClassesWeb();

if (isset($_GET['action_type'])) {
    $acao = trim($_GET['action_type']);
} else {
    $acao = trim($_POST['action_type']);
}

if ($acao === 'gestao_usuarios') {
    if ($_GET['type'] === 'new') {
       $hash = gerar_hash();
       $campos = array('hash', 'nome_completo', 'nome_tratativa', 'email', 'telefone', 'senha', 
       'hierarquia','tipo_usuario', 'empresa');
       foreach($campos as $CAMPOS)
       {
           $variaveis[] = '?';
       }
       $date = date('Y-m-d H:i:s');
       $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
       $valores = array($hash, $_POST['nome_completo'], $_POST['nome_tratativa'], $_POST['email'], 
       $_POST['telefone'], $senha_hash, $_POST['hierarquia'], $_POST['tipo'], $_POST['empresa']);
       
       $email = $_POST['email'];
       $tabela = 'usuarios';
       $consulta_email = $classesWeb->consulta_email($email, $tabela);
       if((int)$consulta_email > 0){
        echo json_encode(array(
            'status' => 'Oops!',
            'message' => 'E-mail já cadastrado',
            'type' => 'close'
        ));
       } else {

            $insert_login = $classesWeb->query_insert(implode(', ', $campos), implode(', ', $variaveis), $valores, 'usuarios');

            if((int) $insert_login > 0) {
                echo json_encode(array(
                    'status' => 'OK',
                    'message' => 'Cadastro realizado com sucesso',
                    'type' => 'redirect',
                    'url' => WEBURL . 'gerenciamento/usuarios'
                ));
        } else {
                echo json_encode(array(
                    'status' => 'Erro',
                    'message' => 'Erro ao realizar cadastro.',
                    'type' => 'close'
                ));
        }
       }
       
    } elseif ($_GET['type'] === 'edit') {
        $campos = array('nome_completo', 'nome_tratativa', 'email', 'telefone',
        'hierarquia', 'tipo_usuario', 'empresa');
        for($i = 0; $i < (int)sizeof($campos); $i++)
        {
            $campos[$i] = $campos[$i] . ' = ?';
        }
        $date = date('Y-m-d H:i:s');
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $valores = array($_POST['nome_completo'], $_POST['nome_tratativa'], $_POST['email'], 
        $_POST['telefone'], $_POST['hierarquia'], $_POST['tipo'], $_POST['empresa']);
        $update = $classesWeb->query_update(implode(', ', $campos), $valores, 'usuarios', 'hash = "' . $_GET['key'] . '"');
        if((int)$update > 0)
        {
            echo json_encode(array(
                'status' => 'OK',
                'message' => 'Usuário alterado com sucesso.',
                'type' => 'redirect',
                'url' => WEBURL . 'gerenciamento/usuarios'
            ));
        } else {
            echo json_encode(array(
                'status' => 'Erro',
                'message' => 'Erro ao atualizar dados do usuário.',
                'type' => 'close'
            ));
        }
    } elseif ($_GET['type'] === 'deletar') {
        $campos = array('status', 'dt_exclusao');
        for($i = 0; $i < (int)sizeof($campos); $i++)
        {
            $campos[$i] = $campos[$i] . ' = ?';
        }
        $date = date('Y-m-d H:i:s');
        $valores = array($_POST['status'], $date);
        $update = $classesWeb->alterar_status(implode(', ', $campos), $valores, 'usuarios', 'hash = "' . $_GET['key'] . '"');
        if((int)$update > 0)
        {
            echo json_encode(array(
                'status' => 'OK',
                'message' => 'Usuário alterado com sucesso.',
                'type' => 'redirect',
                'url' => WEBURL . 'gerenciamento/usuarios'
            ));
        } else {
            echo json_encode(array(
                'status' => 'Erro',
                'message' => 'Erro ao atualizar dados do usuário.',
                'type' => 'close'
            ));
        }
    }
}


