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

if ($acao === 'gestao_clientes_erp') {
    if ($_GET['type'] === 'new') {
        /**
         * Insere um novo cliente erp
         */
     

            $hash_cnae_secundarios = gerar_hash();
            $hash_email = gerar_hash();
            $hash_telefone = gerar_hash();

            $campos = array(
                'hash',
                'razao_social',
                'nome_fantasia',
                'dt_abertura',
                'cnpj',
                'inscricao_estadual',
                'inscricao_municipal',
                'empresa_porte',
                'cnae',
                'cnae_secundarios',
                'natureza_juridica',
                'email',
                'telefone',
                'cep',
                'endereco',
                'numero',
                'complemento',
                'bairro',
                'cidade',
                'estado',
                'pais',
                'dt_cadastro',
                'status',
            );

            $valores = array(
                gerar_hash(),
                $_POST['razao_social'],
                $_POST['nome_fantasia'],
                $_POST['dt_abertura'],
                $_POST['cnpj'],
                $_POST['inscricao_estadual'],
                $_POST['inscricao_municipal'],
                $_POST['empresa_porte'],
                $_POST['cnae'],
                $hash_cnae_secundarios,
                $_POST['natureza_juridica'],
                $hash_email,
                $hash_telefone,
                $_POST['cep'],
                $_POST['logradouro'],
                $_POST['numero'],
                $_POST['complemento'],
                $_POST['bairro'],
                $_POST['cidade'],
                $_POST['estado'],
                $_POST['pais'],
                date("Y-m-d H:i:s"),
                'Ativo'
            );
            foreach ($campos as $CAMPOS_INSERT) {
                $variaveis[] = '?';
            }

            /*
             * Insere os dados na tabela cnae clientes erp
             */

            if (isset($_POST['cnae_secundarios']) && array($_POST['cnae_secundarios']) && !empty($_POST['cnae_secundarios'])) {
                $variavel = array();
                $campo = array('hash', 'cliente_nome', 'cnae_secundario',);
                foreach ($campo as $CAMPOS_INSERT) {
                    $variavel[] = '?';
                }
                //var_dump($_POST['cnae_secundarios']);
                foreach ($_POST['cnae_secundarios'] as $VALUE) {
                    
                    $valor = array($hash_cnae_secundarios, $_POST['nome_fantasia'], $VALUE);
                    $cnae_sec = $classesWeb->query_insert(implode(', ', $campo), implode(', ', $variavel), $valor, 'clientes_erp_cnae');
                    
                };
            }

            /*
             * Insere os dados na tabela email clientes erp
             */

            if (isset($_POST['email']) && array($_POST['email']) && !empty($_POST['email'])) {
                $variavel = array();
                $campo = array('hash', 'email',);
                foreach ($campo as $CAMPOS_INSERT) {
                    $variavel[] = '?';
                }
                //var_dump($_POST['cnae_secundarios']);
                foreach ($_POST['email'] as $VALUE) {
                    
                    $valor = array($hash_email, $VALUE);
                    $email = $classesWeb->query_insert(implode(', ', $campo), implode(', ', $variavel), $valor, 'clientes_erp_email');
                    
                };
            }

            /*
             * Insere os dados na tabela telefones clientes erp
             */

            if (isset($_POST['telefone']) && array($_POST['telefone']) && !empty($_POST['telefone'])) {
                $variavel = array();
                $campo = array('hash', 'setor','nome_responsavel');
                foreach ($campo as $CAMPOS_INSERT) {
                    $variavel[] = '?';
                }
                //var_dump($_POST['cnae_secundarios']);
                foreach ($_POST['telefone'] as $VALUE) {
                    
                    $valor = array($hash_telefone ,$_POST['nome_fantasia'], $VALUE);
                    $telefone = $classesWeb->query_insert(implode(', ', $campo), implode(', ', $variavel), $valor, 'clientes_erp_tel');
                    
                };
            }




            $insert = $classesWeb->query_insert(implode(', ', $campos), implode(', ', $variaveis), $valores, 'clientes_erp');
            if ((int) $insert > 0) {
                echo json_encode(array(
                    'status' => 'OK',
                    'message' => 'Cliente ERP cadastrado com sucesso.',
                    'type' => 'redirect',
                    'url' => WEBURL . 'gerenciamento/clientes-erp'
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
         * Atualiza um cliente erp
         */

        $hash_cnae_secundarios = gerar_hash();
        $hash_email = gerar_hash();
        $hash_telefone = gerar_hash();

        $campos = array(
            'razao_social',
            'nome_fantasia',
            'dt_abertura',
            'cnpj',
            'inscricao_estadual',
            'inscricao_municipal',
            'empresa_porte',
            'cnae',
            //'cnae_secundarios',
            'natureza_juridica',
            'email',
            'telefone',
            'cep',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'estado',
            'pais',
            'dt_atualizacao',

        );

         
        $valores = array(
            $_POST['razao_social'],
            $_POST['nome_fantasia'],
            $_POST['dt_abertura'],
            $_POST['cnpj'],
            $_POST['inscricao_estadual'],
            $_POST['inscricao_municipal'],
            $_POST['empresa_porte'],
            $_POST['cnae'],
           // $_POST['cnae_secundarios'],
            $_POST['natureza_juridica'],
            $_POST['email'],
            $_POST['telefone'],
            $_POST['cep'],
            $_POST['logradouro'],
            $_POST['numero'],
            $_POST['complemento'],
            $_POST['bairro'],
            $_POST['cidade'],
            $_POST['estado'],
            $_POST['pais'],
            date("Y-m-d H:i:s"),
        );

        for ($i = 0; $i < (int) sizeof($campos); $i++) {
            $campos[$i] = $campos[$i] . ' = ?';
        }

        /*if (isset($_POST['cnae_secundarios']) && array($_POST['cnae_secundarios']) && !empty($_POST['cnae_secundarios'])) {
            $variavel = array();
            $campo = array('hash', 'cliente_nome', 'cnae_secundario',);
            foreach ($campo as $CAMPOS_INSERT) {
                $variavel[] = '?';
            }
            //var_dump($_POST['cnae_secundarios']);
            foreach ($_POST['cnae_secundarios'] as $VALUE) {
                
                $valor = array($hash_cnae_secundarios, $_POST['nome_fantasia'], $VALUE);
                $cnae_sec = $classesWeb->query_insert(implode(', ', $campo), implode(', ', $variavel), $valor, 'clientes_erp_cnae');
                
            };
        } */

        
        $update = $classesWeb->query_update(implode(', ', $campos), $valores, 'clientes_erp', 'hash = "' . $_GET['key'] . '"');
        if ((int) $update > 0) {
            echo json_encode(array(
                'status' => 'OK',
                'message' => 'Cliente ERP alterado com sucesso.',
                'type' => 'redirect',
                'url' => WEBURL . 'gerenciamento/clientes-erp'
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
if ($acao === 'delete') {

    $campos = $_POST['data'];
    $variaveis = array();

    $update = $classesWeb->desativar_cliente($campos);
    if ((int) $update > 0) {
        echo json_encode(array(
            'status' => 'OK',
            'message' => 'Cliente ERP desativado.',
            'type' => 'redirect',
            'url' => WEBURL . 'gerenciamento/clientes-erp'
        ));
    } else {
        echo json_encode(array(
            'status' => 'ERROR',
            'message' => 'Ocorreu um erro durante o processo. Tente novamente.',
            'type' => 'close'
        ));
    }
}

if ($acao === 'pegando_estados') {

    $busca_estados = $classesWeb->busca_estado_por_pais($_POST['id_pais']);
    if ((int) $busca_estados > 0) {
        echo json_encode(array(
            'data' => $busca_estados,
            'status' => 'OK',
        ));
    } else {
        echo json_encode(array(
            'status' => 'ERROR',
            'message' => 'Selecione um país.',
            'type' => 'close'
        ));
    }
}

if ($acao === 'pegando_cidades') {

    $busca_cidade = $classesWeb->busca_cidade_por_estado($_POST['estado']);
    //var_dump($busca_cidade);
    if ((int) $busca_cidade > 0) {
        echo '<option value="">Selecione</option>';
        foreach ($busca_cidade as $key => $value) {

            echo '<option data-cidade="' . $value->nome . '" value="' . $value->hash . '">' . $value->nome . '</option>';
        }
    } else {
        echo json_encode(array(
            'status' => 'ERROR',
            'message' => 'Selecione um país.',
            'type' => 'close'
        ));
    }
}
