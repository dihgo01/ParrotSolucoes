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
       $campos = array('hash', 'hierarquia', 'nome_completo', 'nome_tratativa', 'email', 'senha', 'dt_cadastro', 'status');
       foreach($campos as $CAMPO)
       {
           $variaveis[] = '?';
       }
       $date = date('Y-m-d H:i:s');
       $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
       $valores = array(gerar_hash(), $_POST['hierarquia'], $_POST['nome_completo'], $_POST['nome_tratativa'], $_POST['email'],
       $senha_hash, $date, 'Ativo');
       $insert = $classesWeb->query_insert(implode(', ', $campos), implode(', ', $variaveis), $valores, 'usuarios');

       if((int) $insert > 0) {
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
    } elseif ($_GET['type'] === 'edit') {
        $campos = array('hierarquia', 'nome_completo', 'nome_tratativa', 'email', 'senha', 'dt_atualizacao');
        for($i = 0; $i < (int)sizeof($campos); $i++)
        {
            $campos[$i] = $campos[$i] . ' = ?';
        }
        $date = date('Y-m-d H:i:s');
        $valores = array($_POST['hierarquia'], $_POST['nome_completo'], $_POST['nome_tratativa'], $_POST['email'], $_POST['senha'], $date);
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