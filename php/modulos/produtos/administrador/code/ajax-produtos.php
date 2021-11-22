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

if ($acao === 'gestao_de_produtos') {
    if ($_GET['type'] === 'new') {
        /**
         * Insere um novo Produto
         */
            $campos = array(
                'hash',
                'nome',
                'custo',
                'preco',
                'peso',
                'dimensoes',
                'data_lancamento',
                'slug',
                'id_categoria',
                'id_fornecedor',
                'status',
                'descricao',
                'dt_cadastro',
                
            );
          
            //$id_fornecedor = $classesWeb->busca_fornecedor_por_nome($_POST['id_fornecedor']);

            $valores = array(
                gerar_hash(),
                $_POST['nome'],
                $_POST['custo'],
                $_POST['preco'],
                $_POST['peso'],
                $_POST['dimensoes'],
                $_POST['data_lancamento'],
                $_POST['slug'],
                $_POST['id_categoria'],
                $_POST['id_fornecedor'],
                //$id_fornecedor,
                $_POST['status'],
                $_POST['descricao'],
                date("Y-m-d H:i:s"),
                
            );
            foreach ($campos as $CAMPOS_INSERT) {
                $variaveis[] = '?';
            }

            //var_dump($id_fornecedor);
            
            $insert = $classesWeb->query_insert(implode(', ', $campos), implode(', ', $variaveis), $valores, 'produtos');
            if ((int) $insert > 0) {
                echo json_encode(array(
                    'status' => 'OK',
                    'message' => 'Produto cadastrado com sucesso.',
                    'type' => 'redirect',
                    'url' => WEBURL . 'gerenciamento/produtos'
                ));
            } else {
                echo json_encode(array(
                    'status' => 'ERROR',
                    'message' => 'Ocorreu um erro durante o processo. Tente novamente.',
                    'type' => 'close'
                ));
            }
        
    } else {

        /**
         * Atualiza um produto
         */
            $campos = array(
                'hash',
                'nome',
                'custo',
                'preco',
                'peso',
                'dimensoes',
                'data_lancamento',
                'slug',
                'id_categoria',
                'status',
                'id_fornecedor',
                'descricao',
                'dt_atualizacao',
                
            );
            for ($i = 0; $i < (int) sizeof($campos); $i++) {
                $campos[$i] = $campos[$i] . ' = ?';
            }
            $valores = array(
                gerar_hash(),
                $_POST['nome'],
                $_POST['custo'],
                $_POST['preco'],
                $_POST['peso'],
                $_POST['dimensoes'],
                $_POST['data_lancamento'],
                $_POST['slug'],
                $_POST['id_categoria'],
                $_POST['status'],
                $_POST['id_fornecedor'],
                $_POST['descricao'],
                date("Y-m-d H:i:s"),
            );

            $update = $classesWeb->query_update(implode(', ', $campos), $valores, 'produtos', 'hash = "' . $_GET['key'] . '"');
            if ((int) $update > 0) {
                echo json_encode(array(
                    'status' => 'OK',
                    'message' => 'Cadastro alterado com sucesso.',
                    'type' => 'redirect',
                    'url' => WEBURL . 'gerenciamento/produtos'
                ));
            } else {
                echo json_encode(array(
                    'status' => 'ERROR',
                    'message' => 'Ocorreu um erro durante o processo. Tente novamente.',
                    'type' => 'close'
                ));
            }
    
    }
}

if ($acao === 'excluir_item') {
    $campos = array('status');
    for ($i = 0; $i < (int) sizeof($campos); $i++) {
        $campos[$i] = $campos[$i] . ' = ?';
    }
    $valores = array('Esgotado');
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

