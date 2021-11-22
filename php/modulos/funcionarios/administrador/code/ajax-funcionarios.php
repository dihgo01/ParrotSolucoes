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

if ($acao === 'gestao_funcionarios') 
{
    if ($_GET['type'] === 'new') {

        $hash = gerar_hash();

       $campos = array('hash', 'nome_completo', 'nome_tratativa', 'cpf', 'rg', 'dt_nascimento',
       'telefone', 'celular', 'nome_contato_emergencia', 'tel_emergencia', 'email', 'estado_civil', 
       'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 
       'pais', 'funcao', 'dt_admissao', 'dt_cadastro', 'status');

       foreach($campos as $CAMPO)
       {
           $variaveis[] = '?';
       } 

       $date = date('Y-m-d H:i:s');
       
       $cpf = $_POST['cpf'];
       $email = $_POST['email'];
       $tabela = 'funcionarios';
       $data_nascimento = $_POST['dt_nascimento'];
       $tratamento_data_nascimento= implode('-', array_reverse(explode('/', $data_nascimento))); 
       $data_admissao = $_POST['dt_admissao'];
       $tratamento_data_admissao= implode('-', array_reverse(explode('/', $data_admissao))); 

       $valores = array($hash, $_POST['nome_completo'], $_POST['nome_tratativa'], $_POST['cpf'], 
       $_POST['rg'], $tratamento_data_nascimento, $_POST['telefone'], $_POST['celular'], 
       $_POST['nome_contato_emergencia'], $_POST['tel_emergencia'], $_POST['email'], $_POST['estado_civil'],  
       $_POST['cep'], $_POST['logradouro'], $_POST['num_endereco'], $_POST['complemento'], $_POST['bairro'], 
       $_POST['cidade'], $_POST['estado'], $_POST['pais'], $_POST['funcao'], 
       $tratamento_data_admissao, $date, 'Ativo');
       
       $consulta_email = $classesWeb->consulta_email($email, $tabela);
       if((int)$consulta_email > 0) 
       { 
        echo json_encode(array(
            'status' => 'Oops!',
            'message' => 'E-mail já cadastrado',
            'type' => 'close'
        )); 
       }
        else 
        {   
            $insert = $classesWeb->query_insert(implode(', ', $campos), implode(', ', $variaveis), $valores, 'funcionarios');

            if((int) $insert > 0) {
                    echo json_encode(array(
                        'status' => 'OK',
                        'message' => 'Cadastro realizado com sucesso',
                        'type' => 'redirect',
                        'url' => WEBURL . 'gerenciamento/funcionarios'
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
        $campos = array('nome_completo', 'nome_tratativa', 'cpf', 'rg', 'dt_nascimento',
        'telefone', 'celular', 'nome_contato_emergencia', 'tel_emergencia', 'email', 
        'estado_civil', 'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 
        'estado', 'pais', 'funcao', 'dt_admissao', 'dt_atualizacao');
        for($i = 0; $i < (int)sizeof($campos); $i++)
        {
            $campos[$i] = $campos[$i] . ' = ?';
        }
        $date = date('Y-m-d H:i:s');

       $data_nascimento = $_POST['dt_nascimento'];
       $tratamento_data_nascimento= implode('-', array_reverse(explode('/', $data_nascimento))); 
       $data_admissao = $_POST['dt_admissao'];
       $tratamento_data_admissao= implode('-', array_reverse(explode('/', $data_admissao)));  
     
        $valores = array($_POST['nome_completo'], $_POST['nome_tratativa'], $_POST['cpf'],
        $_POST['rg'], $tratamento_data_nascimento, $_POST['telefone'], $_POST['celular'], 
        $_POST['nome_contato_emergencia'], $_POST['tel_emergencia'], $_POST['email'], $_POST['estado_civil'],
        $_POST['cep'], $_POST['logradouro'], $_POST['num_endereco'], $_POST['complemento'], 
        $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['pais'], $_POST['funcao'], 
        $tratamento_data_admissao, $date);
        $update = $classesWeb->query_update(implode(', ', $campos), $valores, 'funcionarios', 'hash = "' . $_GET['key'] . '"');
        if((int)$update > 0)
        {
            echo json_encode(array(
                'status' => 'OK',
                'message' => 'Funcionário alterado com sucesso.',
                'type' => 'redirect',
                'url' => WEBURL . 'gerenciamento/funcionarios'
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