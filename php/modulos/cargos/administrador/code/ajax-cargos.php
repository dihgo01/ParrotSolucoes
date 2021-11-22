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

if ($acao === 'gestao_cargos') 
{
    if ($_GET['type'] === 'new') {

        $hash = gerar_hash();

       $campos = array('hash', 'nome_cargo', 'cbo', 'descricao', 'subordinados', 'superiores', 
       'requisitos_minimos', 'requisitos_desejados', 'atividades_executadas', 'dt_cadastro', 'dt_atualizacao', 
       'status');

       foreach($campos as $CAMPO)
       {
           $variaveis[] = '?';
       } 

       $date = date('Y-m-d H:i:s');

       $valores = array($hash, $_POST['nome_cargo'], $_POST['cbo'], $_POST['descricao'], 
       $_POST['subordinados'], $_POST['superiores'], $_POST['requisitos_minimos'], $_POST['requisitos_desejados'], 
       $_POST['atividades_executadas'], $date, $date, 'Ativo');
    
       $insert = $classesWeb->query_insert(implode(', ', $campos), implode(', ', $variaveis), $valores, 'cargos');

        if((int) $insert > 0) 
        {
            echo json_encode(array(
                'status' => 'OK',
                'message' => 'Cargo cadastrado com sucesso',
                'type' => 'redirect',
                'url' => WEBURL . 'gerenciamento/cargos'
            ));
        } else 
        {
            echo json_encode(array(
                'status' => 'Erro',
                'message' => 'Erro ao realizar cadastro.',
                'type' => 'close'
            ));
        }
  
    } elseif ($_GET['type'] === 'edit') {
        $campos = array('nome_cargo', 'cbo', 'descricao', 'subordinados', 'superiores',
        'requisitos_minimos', 'requisitos_desejados', 'atividades_executadas', 'dt_atualizacao');
        for($i = 0; $i < (int)sizeof($campos); $i++)
        {
            $campos[$i] = $campos[$i] . ' = ?';
        }
        $date = date('Y-m-d H:i:s');
     
        $valores = array($_POST['nome_cargo'], $_POST['cbo'], $_POST['descricao'],
        $_POST['subordinados'], $_POST['superiores'], $_POST['requisitos_minimos'], 
        $_POST['requisitos_desejados'], $_POST['atividades_executadas'], $date);
        $update = $classesWeb->query_update(implode(', ', $campos), $valores, 'cargos', 'hash = "' . $_GET['key'] . '"');
        if((int)$update > 0)
        {
            echo json_encode(array(
                'status' => 'OK',
                'message' => 'Cargo alterado com sucesso.',
                'type' => 'redirect',
                'url' => WEBURL . 'gerenciamento/cargos'
            ));
        } else {
            echo json_encode(array(
                'status' => 'Erro',
                'message' => 'Erro ao atualizar dados do cargo.',
                'type' => 'close'
            ));
        }
    }

}
