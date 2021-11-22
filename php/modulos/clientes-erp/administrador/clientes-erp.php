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
    $current_row = $classesWeb->get_query_unica('SELECT * FROM clientes_erp WHERE hash = "' . $_POST['var4'] . '" AND status <> "Inativo"');
    $busca_email = $classesWeb->consulta_email_clientes_erp($current_row->email);
    if (empty($current_row)) {
        header('Location: /gerenciamento/clientes-erp');
        exit;
    }
} else if (isset($_POST['var3']) and trim($_POST['var3']) === 'delete') {
    $page_start = 'delete';
    header('Location: /gerenciamento/delete_user.php');
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
            'datatable'
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
                    $buscar_clientes_erp = $classesWeb->busca_clientes_erp();
                ?>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-6">
                                    <h3>Gerenciamento de Clientes ERP</h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL ?>"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item">Gerenciamento</li>
                                        <li class="breadcrumb-item active">Clientes ERP</li>
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
                                                    Clientes ERP Cadastrados
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
                                                            <?php if (!empty($buscar_clientes_erp)) { ?>
                                                                <?php
                                                                foreach ($buscar_clientes_erp as $CLIENTES) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $CLIENTES->razao_social ?></td>
                                                                        <td><?php echo $CLIENTES->nome_fantasia ?></td>
                                                                        <td><?php echo $CLIENTES->cnpj ?></td>
                                                                        <td><?php echo $CLIENTES->cli_tel ?></td>
                                                                        <td><?php if ($CLIENTES->status === 'Ativo') {
                                                                                echo "<label class='badge badge-success'>$CLIENTES->status</label>";
                                                                            } elseif ($CLIENTES->status === 'Bloqueado') {
                                                                                echo "<label class='badge badge-danger'>$CLIENTES->status</label>";
                                                                            }
                                                                            ?></td>
                                                                        <td>
                                                                            <div class="dropdown dropdown-item-table">
                                                                                <button type="button" class="btn btn-primary dropbtn dropdown-toggle dropdown-datatable p-2" data-toggle="dropdown"><i class="icofont icofont-arrow-down"></i></button>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item" href="<?php echo WEBURL . 'gerenciamento/clientes-erp/edicao/' . $CLIENTES->hash ?>">Ver/Editar</a>
                                                                                    <a class="dropdown-item" href="#" data-delete-item="<?php echo $CLIENTES->hash ?>" data-delete-table="clientes_erp" data-delete-parameter="hash" data-delete-message="Excluíndo este item, não será possível recuperá-lo posteriormente. Tem certeza que deseja excluí-lo?">Excluir</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tbody>
                                                        <tfoot class="text-center">
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
                                    <h3><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'Edição') ?> de Cliente ERP</h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL ?>"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item">Gerenciamento</li>
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL . 'gerenciamento/clientes-erp' ?>">Clientes ERP</a></li>
                                        <li class="breadcrumb-item "><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'Edição') ?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <form id="form-fornecedores" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL ?>php/modulos/clientes-erp/administrador/code/ajax-clientes-erp.php?action_type=gestao_clientes_erp&type=<?php echo ($page_start === 'cadastro' ? 'new' : 'edit') ?>&key=<?php echo ($page_start === 'cadastro' ? '' : $current_row->hash) ?>" method="POST">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h4 class="mb-5">Dados Cadastrais</h4>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="razao_social">Razão Social</label>
                                                <input type="text" class="form-control" name="razao_social" placeholder="Razão Social" value="<?php echo (isset($current_row->razao_social) ? $current_row->razao_social : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="nome_fantasia">Nome Fantasia</label>
                                                <input type="text" class="form-control" name="nome_fantasia" placeholder="Nome Fantasia" value="<?php echo (isset($current_row->nome_fantasia) ? $current_row->nome_fantasia : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label " for="cnpj">CNPJ</label>
                                                <input type="text" class="form-control search-cnpj field-cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo (isset($current_row->cnpj) ? $current_row->cnpj : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="inscricao_municipal">Inscrição Municipal</label>
                                                <input type="text" class="form-control" name="inscricao_municipal" placeholder="Inscrição Municipal" value="<?php echo (isset($current_row->inscricao_municipal) ? $current_row->inscricao_municipal : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="inscricao_estadual">Inscrição Estadual</label>
                                                <input type="text" class="form-control" name="inscricao_estadual" placeholder="Inscrição Estadual" value="<?php echo (isset($current_row->inscricao_estadual) ? $current_row->inscricao_estadual : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="dt_abertura">Data da Abertura</label>
                                                <input type="text" class="field-get-date form-control " name="dt_abertura" data-language="en" placeholder="__/__/_____" value="<?php echo (isset($current_row->dt_abertura) ? implode('/', array_reverse(explode('-', $current_row->dt_abertura))) : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="porte">Porte da Empresa</label>
                                                <select class="form-control select2" name='empresa_porte' id="inputState" required>
                                                    <?php if (isset($current_row->empresa_porte)) {
                                                        $busca_porte = $classesWeb->busca_empresas_portes();
                                                        if (isset($busca_porte) && !empty($busca_porte)) {
                                                            foreach ($busca_porte as $key => $value) {
                                                                $selected = '';
                                                                if ($value->hash == $current_row->empresas_portes) {
                                                                    $selected = 'selected';
                                                                    echo '<option value="' . $value->hash . '" ' . $selected . '>' . $value->portes . '</option>';
                                                                }
                                                                echo '<option value="' . $value->hash . '">' . $value->portes . '</option>';
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>

                                                        <?php } else {
                                                        $busca_porte = $classesWeb->busca_empresas_portes();
                                                        //var_dump($busca_estados);
                                                        if (isset($busca_porte) && !empty($busca_porte)) {
                                                            echo '<option value="">Selecione</option>';
                                                            foreach ($busca_porte as $key => $value) {
                                                                echo '<option value="' . $value->hash . '">' . $value->portes . '</option>';
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="col-form-label" for="cnae">CNAE Principal</label>
                                                <input type="text" class="form-control mb-3" name="cnae" placeholder="Informe o CNAE principal" value="<?php echo (isset($current_row->cnae) ? $current_row->cnae : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                                <label class="col-form-label" for="natureza_juridica">Natureza Jurídica</label>
                                                <select class="form-control  select2" name='natureza_juridica' id="inputState" placeholder="Selecione" required>
                                                    <?php if (isset($current_row->natureza_juridica)) {
                                                        $busca_nat = $classesWeb->busca_natureza_juridica();
                                                        if (isset($busca_nat) && !empty($busca_nat)) {
                                                            foreach ($busca_nat as $key => $value) {
                                                                $selected = '';
                                                                if ($value->hash == $current_row->natureza_juridica) {
                                                                    $selected = 'selected';
                                                                    echo '<option value="' . $value->hash . '" ' . $selected . '>' . $value->tipo . '</option>';
                                                                }
                                                                echo '<option value="' . $value->hash . '">' . $value->tipo . '</option>';
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>

                                                        <?php } else {

                                                        $busca_nat = $classesWeb->busca_natureza_juridica();
                                                        //var_dump($busca_estados);
                                                        if (isset($busca_nat) && !empty($busca_nat)) {
                                                            echo '<option value="">Selecione</option>';
                                                            foreach ($busca_nat as $key => $value) {
                                                                echo '<option value="' . $value->hash . '">' . $value->tipo . '</option>';
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-5 d-flex justify-content-between">
                                                <h4>Dados Cadastrais Pessoa Física</h4>
                                                <a href="#" id="dados-pessoa" name="cadastro-pessoa" class="btn-add btn-primary"><i data-feather="plus"></i></a>
                                            </div>
                                            <div id="form-dados-pessoa">
                                                <div id="form-pessoa">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="col-form-label" for="nome_pessoa">Nome Completo</label>
                                                        <input type="text" class="form-control" name="nome_pessoa[]" placeholder="Nome Completo" value="<?php echo (isset($current_row->inscricao_estadual) ? $current_row->inscricao_estadual : '') ?>" autocomplete="off" required="">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="col-form-label" for="setor">Setor</label>
                                                        <input type="text" class="form-control" name="setor[]" placeholder="Setor de Trabalho do Responsável" value="<?php echo (isset($current_row->inscricao_estadual) ? $current_row->inscricao_estadual : '') ?>" autocomplete="off" required="">
                                                    </div>
                                                    <div class="col-md-6 mb-3 ">
                                                        <label class="col-form-label" for="email">E-mail</label>
                                                        <input type="text" class="form-control " name="email[]" id="email" placeholder="E-mail" value=" <?php echo (isset($current_row->email) ?: '') ?> " autocomplete="off" required="">
                                                    </div>
                                                    <div class="col-md-6 mb-3 ">
                                                        <label class="col-form-label" for="telefone">Telefone</label>
                                                        <input type="text" class="form-control field-phone" name="telefone[]" id="telefone" placeholder="Informe o telefone com DDD" value="<?php echo (isset($current_row->telefone) ? $current_row->telefone : '') ?>" autocomplete="off" required="">
                                                    </div>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h4 class="mb-5">Endereço</h4>
                                            <div class="col-md-2 mb-3">
                                                <label class="col-form-label ">CEP</label>
                                                <input class="form-control search-cep field-cep" type="text" name="cep" placeholder="CEP" value="<?php echo (isset($current_row->cep) ? $current_row->cep : '') ?>" autocomplete="off" required>
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <label class="col-form-label" for="endereco">Endereço</label>
                                                <input type="text" class="form-control" name="logradouro" placeholder="Endereço" value="<?php echo (isset($current_row->endereco) ? $current_row->endereco : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="col-form-label" for="endereco">Número</label>
                                                <input type="text" class="form-control" name="numero" placeholder="n°" value="<?php echo (isset($current_row->numero) ? $current_row->numero : '') ?>" autocomplete="off" required="">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="col-form-label">Complemento</label>
                                                <input class="form-control" type="text" name="complemento" placeholder="Apartamento, Bloco, Fundos " value="<?php echo (isset($current_row->complemento) ? $current_row->complemento : '') ?>" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">Bairro</label>
                                                <input class="form-control" type="text" name="bairro" placeholder="Bairro" value="<?php echo (isset($current_row->bairro) ? $current_row->bairro : '') ?>" autocomplete="off" required>
                                            </div>
                                            <div class="form-group col-md-3 mb-3">
                                                <label class="col-form-label" for="inputState">Pais</label>
                                                <select class="form-control" name="pais" id="pais" required>
                                                    <?php if (isset($current_row->empresa_porte)) {
                                                        $busca_pais = $classesWeb->busca_pais();
                                                        if (isset($busca_pais) && !empty($busca_pais)) {
                                                            foreach ($busca_pais as $key => $value) {
                                                                $selected = '';
                                                                if ($value->hash == $current_row->pais) {
                                                                    $selected = 'selected';
                                                                    echo '<option value="' . $value->hash . '" ' . $selected . '>' . $value->nome_pt . '</option>';
                                                                }
                                                                echo '<option value="' . $value->hash . '">' . $value->nome_pt . '</option>';
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>
                                                        <?php } else {
                                                        $busca_pais = $classesWeb->busca_pais();
                                                        //var_dump($busca_estados);
                                                        if (isset($busca_pais) && !empty($busca_pais)) {
                                                            echo '<option value="">Selecione</option>';
                                                            foreach ($busca_pais as $key => $value) {
                                                                echo '<option data-estado="' . $value->id . '" value="' . $value->hash . '">' . $value->nome_pt . '</option>';
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-3">
                                                <label class="col-form-label" for="inputState">Estado</label>
                                                <select class="form-control data-estado select2" name="estado" id="estado" placeholder="Selecione" required>
                                                    <?php if (isset($current_row->estado)) {
                                                        $busca_estado = $classesWeb->busca_estado();
                                                        if (isset($busca_estado) && !empty($busca_estado)) {
                                                            foreach ($busca_estado as $key => $value) {
                                                                $selected = '';
                                                                if ($value->hash == $current_row->estado) {
                                                                    $selected = 'selected';
                                                                    echo '<option data-est="' . $value->id . '" data-estado="' . $value->uf . '" value="' . $value->hash . '" ' . $selected . '>' . $value->nome . '</option>';
                                                                }
                                                                echo '<option data-est="' . $value->id . '" data-estado="' . $value->uf . '" value="' . $value->hash . '">' . $value->nome . '</option>';
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>
                                                        <?php } else {
                                                        $busca_estados = $classesWeb->busca_estado();
                                                        //var_dump($busca_estados);
                                                        if (isset($busca_estados) && !empty($busca_estados)) {
                                                            echo '<option value="">Selecione</option>';
                                                            foreach ($busca_estados as $key => $value) {
                                                                echo '<option data-est="' . $value->id . '" data-estado="' . $value->uf . '" value="' . $value->hash . '">' . $value->nome . '</option>';
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 mb-3">
                                                <label class="col-form-label" for="inputState">Cidade</label>
                                                <select class="form-control select2" name="cidade" id="cidade" placeholder="Selecione" required>
                                                    <?php if (isset($current_row->cidade)) {
                                                        $busca_cidade = $classesWeb->busca_cidade();
                                                        if (isset($busca_cidade) && !empty($busca_cidade)) {
                                                            foreach ($busca_cidade as $key => $value) {
                                                                $selected = '';
                                                                if ($value->hash == $current_row->cidade) {
                                                                    $selected = 'selected';
                                                                    echo '<option value="' . $value->hash . '" ' . $selected . '>' . $value->nome . '</option>';
                                                                }
                                                            } ?>
                                                        <?php } else { ?>
                                                            <option selected="">Nada encontrado</option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option selected="">Selecione </option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-5 d-flex justify-content-between">
                                                <h4>CNAE Secundários</h4>
                                                <a href="#" data-toggle="modal" data-target="#exampleModalCenterCNAE" id="cnaes_secundarios" name="cnaes_secundarios" class="btn-add btn-primary modal-fade"><i data-feather="plus"></i></a>
                                            </div>
                                            <div class="form-cnae-secundarios">
                                                <div id="f-cnae-sec">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="col-form-label" for="cnae_secundarios">Código</label>
                                                        <input type="text" class="form-control" name="cnae_secundarios[]" id="cnae_secundarios" placeholder="Informe os CNAEs secundários" value="<?php echo (isset($current_row->cnae_secundarios) ? $current_row->cnae_secundarios : '') ?>" autocomplete="off" required="">
                                                    </div>
                                                    <div class="col-md-12 mb-5">
                                                        <label class="col-form-label" for="descricao">Descrição do CNAE</label>
                                                        <textarea class="form-control" name="descricao" value="" placeholder="Informe a descrição do produto" autocomplete="off" required=""><?php echo (isset($current_row->descricao) ? $current_row->descricao : '') ?></textarea>
                                                    </div>
                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="submit-forms-clientes" class="btn btn-primary" type="submit"><?php echo ($page_start === 'cadastro' ? 'Cadastrar' : 'Atualizar') ?></button>
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
<script src="<?php echo WEBURL ?>php/modulos/clientes-erp/administrador/code/js/clientes-erp.js"></script>
</body>

</html>