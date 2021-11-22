<?php
if(!isset($_SESSION)) {
  session_start();
}
include_once 'code/classes-web.class.php';
include_once 'code/functions.php';
$classesWeb = new ClassesWeb();
sessao();

$page_start = 'listagem';
if(isset($_POST['var3']) AND trim($_POST['var3']) === 'cadastro') {
  $page_start = 'cadastro';
} elseif(isset($_POST['var3']) AND trim($_POST['var3']) === 'edicao'){
  $page_start = 'edicao';
  $current_row = $classesWeb->get_query_unica('SELECT * FROM clientes WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/clientes');
    exit;
  }
} elseif(isset($_POST['var3']) AND trim($_POST['var3']) === 'deletar'){
  $page_start = 'deletar';
  $current_row = $classesWeb->get_query_unica('SELECT * FROM clientes WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/clientes');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?php
        gerar_cabecalho();
        gerar_css(array(
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
            <!-- Page Header Ends -->
            <!-- Page Body Start-->
            <div class="page-body-wrapper">
                <!-- Page Sidebar Start-->
                <?php include_once ROOT . 'php/includes/sidebar-menu.php'; ?>
                <!-- Page Sidebar Ends-->
                <div class="page-body">
                  <?php 
                  if($page_start === 'listagem') {
                    $buscar_clientes = $classesWeb->busca_clientes(); 
                     ?>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-6">
                                    <h3>Listar Clientes</h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL ?>"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item">Gerenciamento</li>
                                        <li class="breadcrumb-item">Dashboard</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="card">
                            <div class="card-header card-no-border">
                            <h5>
                                Clientes
                                <a href="<?php echo WEBURL ?><?php echo $_POST['var1'] ?>/<?php echo $_POST['var2'] ?>/cadastro" class="btn-add btn-primary"><i data-feather="plus"></i></a>
                            </h5>
                            </div>
                            <div class="card-body pt-0">
                              <div class="text-center mt-5 loader-datatable">
                                <div class="loader-box">
                                    <div class="loader-3"></div>
                                </div>
                              </div>
                              <div class="start-datatable-element">
                                <table class="display datatables start-datatable">
                                  <thead class="text-center">
                                    <tr>
                                      <th>Razão Social</th>
                                      <th>Nome Fantasia</th>
                                      <th>CNPJ</th>
                                      <th>E-mail</th>
                                      <th>Telefone</th>
                                      <th>Status</th>
                                      <th>#</th>
                                    </tr>
                                  </thead>
                                  <tbody class="text-center">
                                    <?php if(!empty($buscar_clientes)) { ?>
                                      <?php 
                                        foreach($buscar_clientes as $CLIENTES) { 
                                          ?>
                                          <tr>
                                            <td><?php echo $CLIENTES->razao_social ?></td>
                                            <td><?php echo $CLIENTES->nome_fantasia ?></td>
                                            <td><?php echo $CLIENTES->cnpj ?></td>
                                            <td><?php echo $CLIENTES->email ?></td>
                                            <td><?php echo $CLIENTES->telefone ?></td>
                                            <td><?php if($CLIENTES->status === 'Ativo') 
                                              {
                                                  echo "<label class='badge badge-success'>$CLIENTES->status</label>";
                                              } elseif ($CLIENTES->status === 'Bloqueado') {
                                                echo "<label class='badge badge-danger'>$CLIENTES->status</label>";
                                              }
                                              ?></td>
                                            <td>
                                              <div class="dropdown dropdown-item-table">
                                                  <button type="button" class="btn btn-primary dropbtn dropdown-toggle dropdown-datatable p-2" data-toggle="dropdown"><i class="icofont icofont-arrow-down"></i></button>
                                                  <div class="dropdown-menu">
                                                      <a class="dropdown-item" href="<?php echo WEBURL . 'gerenciamento/clientes/edicao/' . $CLIENTES->hash ?>">Ver/Editar</a>
                                                      <a class="dropdown-item" href="#" data-delete-item="<?php echo $CLIENTES->hash ;?>" data-delete-table="clientes" data-delete-parameter="hash" data-delete-message="mensagem">Excluir</a>
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
                                      <th>E-mail</th>
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
                    <?php } elseif ($page_start === 'cadastro' || $page_start === 'edicao') { ?>
                    <!-- Container-fluid starts-->
                      <div class="container-fluid">
                        <div class="page-title">
                          <div class="row">
                            <div class="col-6">
                              <h3><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'Edição') ?> de Clientes</h3>
                            </div>
                            <div class="col-6">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL; ?>"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Gerenciamento</li>
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL . 'gerenciamento/clientes' ?>">Clientes</a></li>
                                <li class="breadcrumb-item"><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'edicao') ?></li>
                              </ol>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                      <form id="form-usuarios" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL;?>php/modulos/clientes/administrador/code/ajax-clientes.php?action_type=gestao_clientes&type=<?php echo ($page_start === 'cadastro' ? 'new' : 'edit')?>&key=<?php echo ($page_start === 'cadastro' ? '' : $current_row->hash) ?>" method="POST">
                        <div class="col-sm-12">
                          <div id="card-usuario" class="card">
                            <div class="card-body">
                              <div class="row">
                                <h6 class="mb-3">Dados Cadastrais</h6>
                                <div class="col-md-4 mb-3">
                                  <label for="razao_social">Razão Social</label>
                                  <input type="text" class="form-control" name="razao_social" placeholder="Razão Social" value="<?php echo (isset($current_row->razao_social) ? $current_row->razao_social : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label for="nome_fantasia">Nome Fantasia</label>
                                  <input type="text" class="form-control" name="nome_fantasia" placeholder="Nome Fantasia" value="<?php echo (isset($current_row->nome_fantasia) ? $current_row->nome_fantasia : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label for="cnpj">CNPJ</label>
                                  <input type="text" class="form-control field-cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo (isset($current_row->cnpj) ? $current_row->cnpj : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="inscricao_estadual">Inscrição Estadual</label>
                                  <input type="text" class="form-control field-estadual" name="inscricao_estadual" placeholder="Inscrição Estadual" value="<?php echo (isset($current_row->inscricao_estadual) ? $current_row->inscricao_estadual : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="inscricao_municipal">Inscrição Municipal</label>
                                  <input type="text" class="form-control " name="inscricao_municipal" placeholder="Inscrição Municipal" value="<?php echo (isset($current_row->inscricao_municipal) ? $current_row->inscricao_municipal : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label class="col-form-label" for="dt_abertura">Data da Abertura</label>
                                  <input type="text" class="field-get-date form-control " name="dt_abertura" data-language="en" placeholder="__/__/_____" value="<?php echo (isset($current_row->dt_abertura) ? implode('/', array_reverse(explode('-', $current_row->dt_abertura))) : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label class="col-form-label" for="porte">Porte da Empresa</label>
                                  <select class="form-control select2"  name='porte' id="inputState" required="">
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
                                    <label class="col-form-label" for="razao_social">CNAE Secundários</label>
                                    <input type="text" class="form-control" name="cnae_secundarios" placeholder="Informe os CNAEs secundários" value="<?php echo (isset($current_row->cnae_secundarios) ? $current_row->cnae_secundarios : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                  <label class="col-form-label" for="natureza_juridica">Natureza Jurídica</label>
                                  <select class="form-control field-required col-md-12" id="natureza_juridica" name="natureza_juridica" required="">
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
                                  <label for="email">E-mail</label>
                                  <input type="email" class="form-control" name="email" placeholder="E-mail" value="<?php echo (isset($current_row->email) ? $current_row->email : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label for="telefone">Telefone</label>
                                  <input type="text" class="form-control field-phone" name="telefone" placeholder="Informe o telefone com DDD" value="<?php echo (isset($current_row->telefone) ? $current_row->telefone : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-4 mb-5">
                                  <label for="celular">Celular</label>
                                  <input type="text" class="form-control field-phone" name="celular" placeholder="Informe seu celular com DDD" value="<?php echo (isset($current_row->celular) ? $current_row->celular : '') ?>" autocomplete="off" required="">
                                </div>
                                <h6 class="mb-3">Endereço</h6>
                                <div class="col-md-2 mb-3">
                                  <label for="cep">CEP</label>
                                  <input type="text" class="form-control search-cep field-cep" name="cep" placeholder="CEP" value="<?php echo (isset($current_row->cep) ? $current_row->cep : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-5 mb-3">
                                  <label for="logradouro">Endereço</label>
                                  <input type="text" class="form-control" name="logradouro" placeholder="Endereço" value="<?php echo (isset($current_row->endereco) ? $current_row->endereco : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-2 mb-3">
                                  <label for="num_endereco">Nº</label>
                                  <input type="text" class="form-control" name="num_endereco" placeholder="nº" value="<?php echo (isset($current_row->numero) ? $current_row->numero : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="complemento">Complemento</label>
                                  <input type="text" class="form-control" name="complemento" placeholder="Apartamento, bloco, quadra, lote etc." value="<?php echo (isset($current_row->complemento) ? $current_row->complemento : '') ?>" autocomplete="off">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="bairro">Bairro</label>
                                  <input type="text" class="form-control" name="bairro" placeholder="Bairro" value="<?php echo (isset($current_row->bairro) ? $current_row->bairro : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="form-group col-md-3 mb-3">
                                  <label class="col-form-label" for="inputState">País</label>
                                  <select class="form-control" name="pais" id="inputState" data-language="pt-br" required="">
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
                                  <br>
                                <div class="form-group col-md-3 mb-3">
                                  <label class="col-form-label" for="inputState">Estado</label>
                                  <select class="form-control" name="estado" id="estado" placeholder="Selecione" required="">
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
                                <div class="form-group col-md-3 mb-5">
                                  <label class="col-form-label" for="inputState">Cidade</label>
                                  <select class="form-control field-required col-md-12" id="cidade" name="cidade" required="">
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
                                <div class="col-md-12">
                                  <button class="btn btn-primary" type="submit"><?php echo ($page_start === 'cadastro' ? 'Cadastrar' : 'Atualizar') ?></button>
                                </div>
                                  
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <?php } elseif ($page_start === 'deletar') { ?>
                    <!-- Container-fluid starts-->
                      <div class="container-fluid">
                        <div class="page-title">
                          <div class="row">
                            <div class="col-12">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL; ?>"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Gerenciamento</li>
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL . 'gerenciamento/usuarios' ?>">Usuários</a></li>
                                <li class="breadcrumb-item"><?php echo ($page_start === 'cadastro' ? 'cadastro' : 'edicao') ?></li>
                              </ol>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                      <form id="form-usuarios" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL;?>php/modulos/usuarios/administrador/code/ajax-usuarios.php?action_type=gestao_usuarios&type=deletar&key=<?php echo $current_row->hash ?>" method="POST">
                        <div class="col-sm-12">
                          <div class="card">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6 mb-3">
                                  <label for="nome_completo">Selecione uma ação:</label>
                                  <select class="form-control field-required col-md-12" id="status" name="status" required="">
                                  <option value="" selected>-- Selecione uma ação para o usuário selecionado --</option>
                                  <option value="Inativo">Deletar</option>
                                  <option value="Bloqueado">Bloquear</option>
                                  <option value="Ativo">Reativar  </option>
                                </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-12">
                          <div class="card">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <button class="btn btn-primary" name="confirmar" id="confirmar" type="submit" data-mudar-status>Confirmar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <?php } ?>
                  </div>
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
          'mask'
        ));
        ?>  
        <!-- <script src="<?php //echo WEBURL ?>php/modulos/clientes/administrador/code/js/clientes.js"></script> -->
    </body>
</html>