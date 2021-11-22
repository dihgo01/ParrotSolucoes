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
    $current_row = $classesWeb->get_query_unica('SELECT * FROM fornecedores WHERE hash = "' . $_POST['var4'] . '" AND status <> "Inativo"');
    if (empty($current_row)) {
        header('Location: /gerenciamento/fornecedores');
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
                    $buscar_fornecedores = $classesWeb->busca_fornecedores();
                ?>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-6">
                                    <h3>Gerenciamento de Fornecedores</h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL ?>"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item">Gerenciamento</li>
                                        <li class="breadcrumb-item active">Fornecedores</li>
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
                                                    Fornecedores Cadastrados
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
                                                                <th>Razão Social</th>
                                                                <th>Nome Fantasia</th>
                                                                <th>CNPJ</th>
                                                                <th>Telefone</th>
                                                                <th>Status</th>
                                                                <th>#</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            <?php if (!empty($buscar_fornecedores)) { ?>
                                                                <?php
                                                                foreach ($buscar_fornecedores as $FORNECEDOR) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $FORNECEDOR->razao_social ?></td>
                                                                        <td><?php echo $FORNECEDOR->nome_fantasia ?></td>
                                                                        <td><?php echo $FORNECEDOR->cnpj ?></td>
                                                                        <td><?php echo $FORNECEDOR->tel_1 ?></td>
                                                                        <td><?php if($FORNECEDOR->status === 'Ativo') 
                                                                            {
                                                                                echo "<label class='badge badge-success'>$FORNECEDOR->status</label>";
                                                                            } elseif ($FORNECEDOR->status === 'Bloqueado') {
                                                                                echo "<label class='badge badge-danger'>$FORNECEDOR->status</label>";
                                                                            }
                                                                            ?></td>
                                                                        <td>
                                                                            <div class="dropdown dropdown-item-table">
                                                                                <button type="button" class="btn btn-primary dropbtn dropdown-toggle dropdown-datatable p-2" data-toggle="dropdown"><i class="icofont icofont-arrow-down"></i></button>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item" href="<?php echo WEBURL . 'gerenciamento/fornecedores/edicao/' . $FORNECEDOR->hash ?>">Ver/Editar</a>
                                                                                    <a class="dropdown-item" href="#" data-delete-item="<?php echo $FORNECEDOR->hash ?>" data-delete-table="fornecedores" data-delete-parameter="hash" data-delete-message="Excluíndo este item, não será possível recuperá-lo posteriormente. Tem certeza que deseja excluí-lo?">Excluir</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tbody> 
                                                        <tfoot>
                                                            <tr>
                                                                <th>Razão Social</th>
                                                                <th>Nome Fantasia</th>
                                                                <th>CNPJ</th>
                                                                <th>Telefone</th>
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
                                    <h3><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'Edição') ?> de Fornecedores</h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL ?>"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item">Gerenciamento</li>
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL . 'gerenciamento/fornecedores' ?>">Clientes ERP</a></li>
                                        <li class="breadcrumb-item "><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'Edição') ?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <form id="form-fornecedores" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL ?>php/modulos/fornecedores/administrador/code/ajax-fornecedores.php?action_type=gestao_de_fornecedores&type=<?php echo ($page_start === 'cadastro' ? 'new' : 'edit') ?>&key=<?php echo ($page_start === 'cadastro' ? '' : $current_row->hash) ?>" method="POST">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h6 class="mb-3">Dados Cadastrais</h6>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="razao_social">Razão Social</label>
                                                <input type="text" class="form-control" name="razao_social" placeholder="Razão Social" value="<?php echo (isset($current_row->razao_social) ? $current_row->razao_social : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="nome_fantasia">Nome Fantasia</label>
                                                <input type="text" class="form-control" name="nome_fantasia" placeholder="Nome Fantasia" value="<?php echo (isset($current_row->nome_fantasia) ? $current_row->nome_fantasia : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label " for="razao_social">CNPJ</label>
                                                <input type="text" class="form-control field-cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo (isset($current_row->cnpj) ? $current_row->cnpj : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="col-form-label" for="razao_social">Inscrição Estadual</label>
                                                <input type="text" class="form-control" name="inscricao_estadual" placeholder="Inscrição Estadual" value="<?php echo (isset($current_row->inscricao_estadual) ? $current_row->inscricao_estadual : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="col-form-label" for="razao_social">Inscrição Muncipal</label>
                                                <input type="text" class="form-control" name="inscricao_municipal" placeholder="Inscrição Municipal" value="<?php echo (isset($current_row->inscricao_municipal) ? $current_row->inscricao_municipal : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="col-form-label" for="razao_social">Data da Abertura</label>
                                                <input type="text" class="field-get-date field-get-date form-control field-date" data-language="en" name="dt_abertura" placeholder="Data da Abertura da Empresa" value="<?php echo (isset($current_row->dt_abertura) ? implode('/', array_reverse(explode('-', $current_row->dt_abertura))) : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="col-form-label" for="porte">Porte da Empresa</label>
                                                <select class="form-control select2" name='porte' id="inputState" required="">
                                                    <option value="<?php if($page_start === 'edicao') { 
                                                    echo (isset($current_row->porte) ? $current_row->porte : ''); }?>" selected>
                                                    <?php if($page_start === 'edicao') { 
                                                    echo (isset($current_row->porte) ? $current_row->porte : ''); } else {
                                                    echo "Selecione";
                                                    }
                                                    ?> </option>
                                                    <?php 
                                                    $porte = $classesWeb->busca_porte();
                                                    if (!empty($porte))
                                                    {
                                                    foreach($porte as $PORTE) {
                                                    ?> <option> <?php echo $PORTE->tipo ?> </option>
                                                    <?php } 
                                                    } 
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="razao_social">CNAE Principal</label>
                                                <input type="text" class="form-control" name="cnae" placeholder="Informe o CNAE principal" value="<?php echo (isset($current_row->cnae) ? $current_row->cnae : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="cnae_secundarios">CNAE Secundários</label> 
                                                <div class="d-flex">
                                                    <input type="text" class="form-control" name="cnae_secundarios" placeholder="Informe os CNAEs secundários" value="<?php echo (isset($current_row->cnae_secundarios) ? $current_row->cnae_secundarios : '') ?>" autocomplete="off" required="">
                                                    <a href="#"  data-toggle="modal" data-target="#exampleModalCenterCNAE" id="cnaes" name="cnaes" class="btn-add btn-primary modal-fade"><i data-feather="plus" ></i></a>   
                                                    <div class="form-group modal fade" id="exampleModalCenterCNAE" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterCNAE" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Adicionar CNAEs </h5>
                                                                    <button class="close btn-primary btn-add" type="button" data-dismiss="modal" id="cnaes_close" aria-label="Close"><span aria-hidden="true">X</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Descrição da política de privacidade.</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="button">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                                <label class="col-form-label" for="nat_juridica">Natureza Juridica</label>
                                                <select class="form-control  select2" name='nat_juridica' id="inputState" placeholder="Selecione" required="">
                                                    <option value="<?php if($page_start === 'edicao') { 
                                                        echo (isset($current_row->nat_juridica) ? $current_row->nat_juridica : ''); }?>" selected>
                                                        <?php if($page_start === 'edicao') { 
                                                        echo (isset($current_row->nat_juridica) ? $current_row->nat_juridica : ''); } else {
                                                        echo "Selecione";
                                                        }
                                                        ?> </option>
                                                    <?php 
                                                        $natureza_juridica = $classesWeb->busca_nat_juridica();
                                                        if (!empty($natureza_juridica))
                                                        {
                                                        foreach($natureza_juridica as $NATUREZA) {
                                                        ?> <option> <?php echo $NATUREZA->tipo ?> </option>
                                                        <?php } 
                                                        } 
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="razao_social">E-mail</label>
                                                <div class="d-flex">
                                                <input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo (isset($current_row->email) ? $current_row->email : '') ?>" autocomplete="off" required="">
                                                    <a href="#"  data-toggle="modal" data-target="#exampleModalCenterEmails" id="emails" name="emails" class="btn-add btn-primary modal-fade"><i data-feather="plus" ></i></a>   
                                                    <div class="form-group modal fade" id="exampleModalCenterEmails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterEmails" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Adicionar E-mails </h5>
                                                                    <button class="close btn-primary btn-add" type="button" data-dismiss="modal" id="emails_close" aria-label="Close"><span aria-hidden="true">X</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Descrição da política de privacidade.</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="button">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-5">
                                                <label class="col-form-label " for="razao_social">Celular</label>
                                                <input type="text" class="form-control field-phone" name="tel_2" placeholder="Informe o celular com DDD" value="<?php echo (isset($current_row->tel_2) ? $current_row->tel_2 : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label " for="razao_social">Telefone</label>
                                                <div class="d-flex">
                                                    <input type="text" class="form-control field-phone" name="tel_1" placeholder="Informe o telefone com DDD" value="<?php echo (isset($current_row->tel_1) ? $current_row->tel_1 : '') ?>" autocomplete="off" required="">
                                                    <a href="#"  data-toggle="modal" data-target="#exampleModalCenterTelefone" id="telefones" name="telefones" class="btn-add btn-primary modal-fade"><i data-feather="plus" ></i></a>   
                                                    <div class="form-group modal fade" id="exampleModalCenterTelefone" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTelefone" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Adicionar Telefones </h5>
                                                                    <button class="close btn-primary btn-add" type="button" data-dismiss="modal" id="telefones_close" aria-label="Close"><span aria-hidden="true">X</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Descrição da política de privacidade.</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="button">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h6 class="mb-3">Endereço</h6>
                                            <div class="col-md-2">
                                                <label class="col-form-label ">CEP</label>
                                                <input class="form-control search-cep field-cep" type="text" name="cep" placeholder="CEP" value="<?php echo (isset($current_row->cep) ? $current_row->cep : '') ?>" autocomplete="off" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label" for="endereco">Endereço</label>
                                                <input type="text" class="form-control" name="logradouro" placeholder="Endereço" value="<?php echo (isset($current_row->endereco) ? $current_row->endereco : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-1 mb-3">
                                                <label class="col-form-label" for="endereco">Numero</label>
                                                <input type="text" class="form-control" name="numero" placeholder="n°" value="<?php echo (isset($current_row->numero) ? $current_row->numero : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="col-form-label">Complemento</label>
                                                <input class="form-control" type="text" name="complemento" placeholder="Apartamento, bloco, quadra, lote etc." value="<?php echo (isset($current_row->complemento) ? $current_row->complemento : '') ?>" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">Bairro</label>
                                                <input class="form-control" type="text" name="bairro" placeholder="Bairro" value="<?php echo (isset($current_row->bairro) ? $current_row->bairro : '') ?>" autocomplete="off" required>
                                            </div>
                                            <div class="form-group col-md-3 mb-5">
                                                <label class="col-form-label" for="inputState">Pais</label>
                                                <select class="form-control" name="pais" id="inputState" required="">
                                                    <option value="<?php if($page_start === 'edicao') { 
                                                    echo (isset($current_row->pais) ? $current_row->pais : ''); }?>" selected>
                                                    <?php if($page_start === 'edicao') { 
                                                    echo (isset($current_row->pais) ? $current_row->pais : ''); } else {
                                                    echo "Selecione";
                                                    }
                                                    ?> </option>
                                                    <?php 
                                                    $pais = $classesWeb->busca_pais();
                                                    if (!empty($pais))
                                                    {
                                                    foreach($pais as $PAIS) {
                                                    ?> <option> <?php echo $PAIS->nome_pt ?> </option>
                                                    <?php } 
                                                    } 
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-3">
                                                <label class="col-form-label" for="inputState">Estado</label>
                                                <select class="form-control data-estado select2" name="estado" id="estado" placeholder="Selecione" required="">
                                                <option value="<?php if($page_start === 'edicao') { 
                                                        echo (isset($current_row->estado) ? $current_row->estado : ''); }?>" selected>
                                                        <?php if($page_start === 'edicao') { 
                                                        echo (isset($current_row->estado) ? $current_row->estado : ''); } else {
                                                        echo "Selecione";
                                                        } ?> 
                                                </option>
                                                    <?php 
                                                        $estado = $classesWeb->busca_estado();
                                                        if (!empty($estado))
                                                        {
                                                        foreach($estado as $ESTADO) {
                                                        ?> <option> <?php echo $ESTADO->nome ?> </option>
                                                        <?php } 
                                                        } 
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-3">
                                                <label class="col-form-label" for="inputState">Cidade</label>
                                                <select class="form-control select2" name="cidade" id="cidade" placeholder="Selecione" required="">
                                                    <option value="<?php if($page_start === 'edicao') { 
                                                    echo (isset($current_row->cidade) ? $current_row->cidade : ''); }?>" selected>
                                                    <?php if($page_start === 'edicao') { 
                                                    echo (isset($current_row->cidade) ? $current_row->cidade : ''); } else {
                                                    echo "Selecione";
                                                    }
                                                    ?> </option>
                                                    <?php 
                                                    $cidade = $classesWeb->busca_cidade();
                                                    if (!empty($cidade))
                                                    {
                                                    foreach($cidade as $CIDADE) {
                                                    ?> <option> <?php echo $CIDADE->nome ?> </option>
                                                    <?php } 
                                                    } 
                                                    ?>
                                                </select>
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
        'mask'
    ));
    ?>
    <script src="<?php echo WEBURL ?>php/modulos/fornecedores/administrador/code/js/fornecedores-erp.js"></script>
</body>

</html>