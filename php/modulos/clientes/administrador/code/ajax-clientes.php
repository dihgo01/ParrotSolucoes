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

if ($acao === 'gestao_clientes') {
    if ($_GET['type'] === 'new') {
        $hash = gerar_hash();
       $campos = array('hash', 'razao_social', 'nome_fantasia', 'cnpj', 'inscricao_estadual', 
       'inscricao_municipal', 'dt_abertura', 'porte', 'cnae', 'cnae_secundarios', 'natureza_juridica', 'email', 'telefone', 
       'celular', 'cep', 'endereco', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'pais', 'dt_cadastro',
       'status');
       foreach($campos as $CAMPO)
       {
           $variaveis[] = '?';
       } 

       $date = date('Y-m-d H:i:s');
       
       $data = $_POST['dt_abertura'];
       $data_abertura = implode('-', array_reverse(explode('/', $data)));    
       
       $valores = array($hash, $_POST['razao_social'], $_POST['nome_fantasia'], $_POST['cnpj'], 
       $_POST['inscricao_estadual'], $_POST['inscricao_municipal'], $data_abertura, $_POST['porte'], 
       $_POST['cnae'], $_POST['cnae_secundarios'], $_POST['natureza_juridica'], $_POST['email'], $_POST['telefone'],  
       $_POST['celular'], $_POST['cep'], $_POST['logradouro'], $_POST['num_endereco'], $_POST['complemento'], 
       $_POST['bairro'], $_POST['estado'], $_POST['cidade'], $_POST['pais'], $date, 'Ativo');
       
      
       $tabela = 'clientes';
       $email = $_POST['email'];
       $consulta_email = $classesWeb->consulta_email($email, $tabela);
       if((int)$consulta_email > 0){
        echo json_encode(array(
            'status' => 'Oops!',
            'message' => 'E-mail já cadastrado',
            'type' => 'close'
        ));
       } else 
        {
            $insert = $classesWeb->query_insert(implode(', ', $campos), implode(', ', $variaveis), $valores, 'clientes');

            if((int) $insert > 0) {
                    echo json_encode(array(
                        'status' => 'OK',
                        'message' => 'Cadastro realizado com sucesso',
                        'type' => 'redirect',
                        'url' => WEBURL . 'gerenciamento/clientes'
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
        $campos = array('razao_social', 'nome_fantasia', 'cnpj', 'inscricao_estadual', 
        'inscricao_municipal', 'dt_abertura', 'porte', 'cnae', 'cnae_secundarios', 'natureza_juridica', 'email', 'telefone', 
        'celular', 'cep', 'endereco', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'pais', 'dt_atualizacao');
        for($i = 0; $i < (int)sizeof($campos); $i++)
        {
            $campos[$i] = $campos[$i] . ' = ?';
        }
        $date = date('Y-m-d H:i:s');

        $data = $_POST['dt_abertura'];
        $data_abertura = implode('-', array_reverse(explode('/', $data)));  


        $valores = array($_POST['razao_social'], $_POST['nome_fantasia'], $_POST['cnpj'], 
        $_POST['inscricao_estadual'], $_POST['inscricao_municipal'], $data_abertura, $_POST['porte'], 
        $_POST['cnae'], $_POST['cnae_secundarios'], $_POST['natureza_juridica'], $_POST['email'], $_POST['telefone'],  
        $_POST['celular'], $_POST['cep'], $_POST['logradouro'], $_POST['num_endereco'], $_POST['complemento'], 
        $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['pais'], $date);
        $update = $classesWeb->query_update(implode(', ', $campos), $valores, 'clientes', 'hash = "' . $_GET['key'] . '"');
        if((int)$update > 0)
        {
            echo json_encode(array(
                'status' => 'OK',
                'message' => 'Cliente alterado com sucesso.',
                'type' => 'redirect',
                'url' => WEBURL . 'gerenciamento/clientes'
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
        $update = $classesWeb->alterar_status(implode(', ', $campos), $valores, 'clientes', 'hash = "' . $_GET['key'] . '"');
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

if ($acao === 'pegando_cidades') {

    $busca_cidade = $classesWeb->busca_cidade_por_estado($_POST['estado']);
    //var_dump($busca_cidade);
    foreach ($busca_cidade as $key => $value) {
        echo '<option data-cidade="' . $value->uf . '" value="' . $value->nome . '">' . $value->nome . '</option>';
    }
}

