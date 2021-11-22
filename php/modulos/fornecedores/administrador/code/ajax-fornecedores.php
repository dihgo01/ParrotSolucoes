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

if ($acao === 'gestao_de_fornecedores') {
    if ($_GET['type'] === 'new') {
        /**
         * Insere um novo fornecedor
         */
        $email = $_POST['email'];
        $data = $_POST['dt_abertura'];
        $data_abertura = implode('-', array_reverse(explode('/', $data)));  

        if($_GET['type'] === 'new')
        {
        $consulta_email = $classesWeb->consulta_email($email, 'fornecedores');
        }
        //var_dump($consulta_email);
        if (isset($consulta_email) && (int)$consulta_email > 0) {
            echo json_encode(array(
                'status' => 'Oops!',
                'message' => 'E-mail já cadastrado',
                'type' => 'close'
            ));
        } else {
            $campos = array(
                'hash',
                'razao_social',
                'nome_fantasia',
                'dt_abertura',
                'cnpj',
                'inscricao_estadual',
                'inscricao_municipal',
                'porte',
                'cnae',
                'cnae_secundarios',
                'nat_juridica',
                'email',
                'tel_1',
                'tel_2',
                'cep',
                'endereco',
                'numero',
                'complemento',
                'bairro',
                'cidade',
                'estado',
                'pais',
                'dt_cadastro',
                'dt_atualizacao',
                'dt_exclusao',
                'status',
            );

            $valores = array(
                gerar_hash(),
                $_POST['razao_social'],
                $_POST['nome_fantasia'],
                $data_abertura,
                $_POST['cnpj'],
                $_POST['inscricao_estadual'],
                $_POST['inscricao_municipal'],
                $_POST['porte'],
                $_POST['cnae'],
                $_POST['cnae_secundarios'],
                $_POST['nat_juridica'],
                $_POST['email'],
                $_POST['tel_1'],
                $_POST['tel_2'],
                $_POST['cep'],
                $_POST['logradouro'],
                $_POST['numero'],
                $_POST['complemento'],
                $_POST['bairro'],
                $_POST['cidade'],
                $_POST['estado'],
                $_POST['pais'],
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
                'Ativo'
            );
            foreach ($campos as $CAMPOS_INSERT) {
                $variaveis[] = '?';
            }

            $insert = $classesWeb->query_insert(implode(', ', $campos), implode(', ', $variaveis), $valores, 'fornecedores');
            if ((int) $insert > 0) {
                echo json_encode(array(
                    'status' => 'OK',
                    'message' => 'Fornecedores cadastrado com sucesso.',
                    'type' => 'redirect',
                    'url' => WEBURL . 'gerenciamento/fornecedores'
                ));
            } else {
                echo json_encode(array(
                    'status' => 'ERROR',
                    'message' => 'Ocorreu um erro durante o processo. Tente novamente.',
                    'type' => 'close'
                ));
            }
        }
    } else {

        /**
         * Atualiza um fornecedor
         */

        $email = $_POST['email'];
        if($_GET['type'] === 'new')
        {
        $consulta_email = $classesWeb->consulta_email($email, 'fornecedores');
        }
        //var_dump($consulta_email);
        if (isset($consulta_email) && (int)$consulta_email > 0) {
            echo json_encode(array(
                'status' => 'Oops!',
                'message' => 'E-mail já cadastrado',
                'type' => 'close'
            ));
        } else {
            $campos = array(
                'hash',
                'razao_social',
                'nome_fantasia',
                'dt_abertura',
                'cnpj',
                'inscricao_estadual',
                'inscricao_municipal',
                'porte',
                'cnae',
                'cnae_secundarios',
                'nat_juridica',
                'email',
                'tel_1',
                'tel_2',
                'cep',
                'endereco',
                'numero',
                'complemento',
                'bairro',
                'cidade',
                'estado',
                'pais',
                'dt_cadastro',
                'dt_atualizacao',
                'dt_exclusao',
                'status',
            );
            for ($i = 0; $i < (int) sizeof($campos); $i++) {
                $campos[$i] = $campos[$i] . ' = ?';
            }

            $data = $_POST['dt_abertura'];
            $data_abertura = implode('-', array_reverse(explode('/', $data)));  

            $valores = array(
                gerar_hash(),
                $_POST['razao_social'],
                $_POST['nome_fantasia'],
                $data_abertura,
                $_POST['cnpj'],
                $_POST['inscricao_estadual'],
                $_POST['inscricao_municipal'],
                $_POST['porte'],
                $_POST['cnae'],
                $_POST['cnae_secundarios'],
                $_POST['nat_juridica'],
                $_POST['email'],
                $_POST['tel_1'],
                $_POST['tel_2'],
                $_POST['cep'],
                $_POST['logradouro'],
                $_POST['numero'],
                $_POST['complemento'],
                $_POST['bairro'],
                $_POST['cidade'],
                $_POST['estado'],
                $_POST['pais'],
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
                'Ativo'
            );

            $update = $classesWeb->query_update(implode(', ', $campos), $valores, 'fornecedores', 'hash = "' . $_GET['key'] . '"');
            if ((int) $update > 0) {
                echo json_encode(array(
                    'status' => 'OK',
                    'message' => 'Cadastro alterado com sucesso.',
                    'type' => 'redirect',
                    'url' => WEBURL . 'gerenciamento/fornecedores'
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
}



if ($acao === 'pegando_cidades') {

    $busca_cidade = $classesWeb->busca_cidade_por_estado($_POST['estado']);
    //var_dump($busca_cidade);
    foreach ($busca_cidade as $key => $value) {
        echo '<option data-cidade="' . $value->uf . '" value="' . $value->nome . '">' . $value->nome . '</option>';
    }
}
