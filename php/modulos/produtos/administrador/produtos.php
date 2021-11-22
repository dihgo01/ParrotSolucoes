<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once 'code/classes-web.class.php';
include_once 'code/functions.php';
$classesWeb = new ClassesWeb();


$page_start = 'listagem';
if (isset($_POST['var3']) and trim($_POST['var3']) === 'cadastro') {
    $page_start = 'cadastro';
} else if (isset($_POST['var3']) and trim($_POST['var3']) === 'edicao') {
    $page_start = 'edicao';
    $current_row = $classesWeb->get_query_unica('SELECT * ,fornecedores.nome_fantasia AS forn_nome, produtos.hash AS hash_prod  FROM produtos INNER JOIN fornecedores ON produtos.id_fornecedor = fornecedores.hash WHERE produtos.hash = "' . $_POST['var4'] . '');
    if (empty($current_row)) {
        header('Location: /gerenciamento/produtos');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php
    gerar_cabecalho();
    gerar_css(
        array(
            'toastr',
            'date-picker',
            'summernote',
            'management',
            'datatable',
            'select2'
        )
    );
    ?>
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <?php include_once ROOT . 'php/includes/page-header.php'; ?>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <?php include_once ROOT . 'php/includes/sidebar-menu.php'; ?>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <?php
                if ($page_start === 'listagem') {
                    $buscar_produtos = $classesWeb->busca_produtos();
                ?>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-6">
                                    <h3>Gerenciamento de Produtos</h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL ?>"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item">Gerenciamento</li>
                                        <li class="breadcrumb-item active">Produtos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-12 box-col-12 xl-100">
                                <div class="row">
                                    <div class="col-xl-12 box-col-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header card-no-border">
                                                <h5>
                                                    Produtos Cadastrados
                                                    <a href="<?php echo WEBURL ?><?php echo $_POST['var1'] ?>/<?php echo $_POST['var2'] ?>/cadastro" class="btn-add btn-primary"><i data-feather="plus"></i></a>
                                                </h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="text-center mt-5 loader-datatable">
                                                    <div class="loader-box">
                                                        <div class="loader-3"></div>
                                                    </div>
                                                </div>
                                                <div class="start-datatable-elemet">
                                                    <table class="display datatables start-datatable">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th>Nome</th>
                                                                <th>Custo</th>
                                                                <th>Data de Lançamento</th>
                                                                <th>Situação</th>
                                                                <th>Fornecedor</th>
                                                                <th>Status</th>
                                                                <th>#</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            <?php if (!empty($buscar_produtos)) { ?>
                                                                <?php
                                                                foreach ($buscar_produtos as $Produtos) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $Produtos->nome ?></td>
                                                                        <td><?php echo $Produtos->custo ?></td>
                                                                        <td><?php echo $Produtos->data_lancamento ?></td>
                                                                        <td><?php echo "<label class='badge badge-success'>Em Estoque</label>" ?></td>
                                                                        <td><?php echo $Produtos->forn_nome ?></td>
                                                                        <td><?php echo "<label class='badge badge-success'>Ativo</label>" ?></td>
                                                                        <td>
                                                                            <div class="dropdown dropdown-item-table">
                                                                                <button type="button" class="btn btn-primary dropbtn dropdown-toggle dropdown-datatable p-2" data-toggle="dropdown"><i class="icofont icofont-arrow-down"></i></button>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item" href="<?php echo WEBURL . 'gerenciamento/produtos/edicao/' . $Produtos->hash_prod ?>">Ver/Editar</a>
                                                                                    <a class="dropdown-item" href="#" data-delete-prod="<?php echo $Produtos->hash_prod  ?>" data-delete-table-prod="produtos" data-delete-param="hash" data-delete-msg="Excluíndo este item, não será possível recuperá-lo posteriormente. Tem certeza que deseja excluí-lo?">Excluir</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tbody> 
                                                        <tfoot>
                                                            <tr>
                                                                <th>Nome</th>
                                                                <th>Custo</th>
                                                                <th>Data de Lançamento</th>
                                                                <th>Situação</th>
                                                                <th>Fornecedor</th>
                                                                <th>Status</th>
                                                                <th>#</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else if ($page_start === 'cadastro' || $page_start === 'edicao') { ?>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-6">
                                    <h3><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'Edição') ?> de Produtos</h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL ?>"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item">Gerenciamento</li>
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL . 'gerenciamento/produtos' ?>"> Produtos</a></li>
                                        <li class="breadcrumb-item "><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'Edição') ?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <form id="form-produtos" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL ?>php/modulos/produtos/administrador/code/ajax-produtos.php?action_type=gestao_de_produtos&type=<?php echo ($page_start === 'cadastro' ? 'new' : 'edit') ?>&key=<?php echo ($page_start === 'cadastro' ? '' : $current_row->hash) ?>" method="POST">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h6 class="mb-3">Dados Cadastrais</h6>
                                            <div class="mb-3">
                                                <label class="col-form-label " for="nome">Nome</label>
                                                <input type="text" class="form-control " name="nome" placeholder="Nome do Produto" value="<?php echo (isset($current_row->nome) ? $current_row->nome : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="custo">Custo</label>
                                                <input type="text" class="form-control field-currency" name="custo" placeholder="R$00,00" value="<?php echo (isset($current_row->custo) ? $current_row->custo : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="preco">Preço</label>
                                                <input type="text" class="form-control field-currency" name="preco" placeholder="R$00,00" value="<?php echo (isset($current_row->preco) ? $current_row->preco : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="peso">Peso</label>
                                                <input type="text" class="form-control weight" name="peso" placeholder="Peso em Kg" value="<?php echo (isset($current_row->peso) ? $current_row->peso : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="dimensoes">Dimensões</label>
                                                <input type="text" class="form-control" name="dimensoes" placeholder="Dimensões em Metros" value="<?php echo (isset($current_row->dimensoes) ? $current_row->dimensoes : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="data_lancamento">Data do Lançamento</label>
                                                <input type="text" class="datepicker-here form-control field-date" data-language="en" name="data_lancamento" placeholder="Selecione a data de lançamento" value="<?php echo (isset($current_row->data_lancamento) ? $current_row->data_lancamento : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-form-label">Palavra Chave</label>
                                                <input class="form-control" type="text" name="slug" placeholder="Slug do Produto" value="<?php echo (isset($current_row->slug) ? $current_row->slug : '') ?>" autocomplete="off" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-form-label">Categoria do Produto</label>
                                                <input class="form-control" type="text" name="id_categoria" placeholder="Categoria" value="<?php echo (isset($current_row->id_categoria) ? $current_row->id_categoria : '') ?>" autocomplete="off" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                            <label class="col-form-label" for="id_fornecedor">Fornecedor do Produto</label>
                                                <select class="form-control select2" name='id_fornecedor' id="id_fornecedor">
                                                    <?php if (isset($current_row->forn_nome)) {
                                                        echo "<option selected >$current_row->forn_nome</option>"; ?>
                                                        <?php
                                                    } else {
                                                        $busca_fornecedor = $classesWeb->busca_fornecedores();
                                                        //var_dump($busca_estados);
                                                        if (isset($busca_fornecedor) && !empty($busca_fornecedor)) {
                                                            echo '<option value="">Selecione</option>';
                                                            foreach ($busca_fornecedor as $key => $value) {
                                                                echo '<option data-id="'.$value->id.'" value="' . $value->hash . '">' . $value->nome_fantasia . '</option>';
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>


                                            <div class="form-group col-md-4 mb-3">
                                                <label class="col-form-label" for="inputState">Situação do Produto</label>
                                                <select class="form-control" name="status" id="inputState">
                                                    <?php if (isset($current_row->status)) {
                                                        echo "<option selected >$current_row->status</option>",
                                                        "<option>Lançamento</option>",
                                                        "<option>Em Estoque</option>",
                                                        "<option>Esgotado</option>"; ?>
                                                    <?php
                                                    } else { ?>
                                                        <option selected="">Selecione</option>
                                                        <option>Lançamento</option>
                                                        <option>Em Estoque</option>
                                                        <option>Esgotado</option>

                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-5">
                                                <label class="col-form-label" for="descricao">Descrição do Produto</label>
                                                <textarea type="text" class="form-control" name="descricao" value="" placeholder="Informe a descrição do produto" autocomplete="off" required=""><?php echo (isset($current_row->descricao) ? $current_row->descricao : '') ?></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button id="submit-forms" class="btn btn-primary" type="submit"><?php echo ($page_start === 'cadastro' ? 'Cadastrar' : 'Atualizar') ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                <?php } ?>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            <?php include_once ROOT . 'php/includes/rodape.php'; ?>
        </div>
    </div>
    <?php
    gerar_rodape();
    gerar_js(array(
        'toastr',
        'date-picker',
        'summernote',
        'datatable',
        'sweetalert',
        'form-submit',
        'management',
        'select2',
        'mask',
        'mask-money'
    ));
    ?>
    <script src="<?php echo WEBURL ?>php/modulos/produtos/administrador/code/js/produtos.js"></script>
</body>

</html>