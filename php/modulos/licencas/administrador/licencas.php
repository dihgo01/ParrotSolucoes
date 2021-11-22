<?php
if(!isset($_SESSION)) {
  session_start();
}
include_once 'code/classes-web.class.php';
include_once 'code/functions.php';
$classesWeb = new ClassesWeb();

$page_start = 'listagem';
if(isset($_POST['var3']) AND trim($_POST['var3']) === 'cadastro') {
  $page_start = 'cadastro';
} elseif(isset($_POST['var3']) AND trim($_POST['var3']) === 'edicao'){
  $page_start = 'edicao';
  $current_row = $classesWeb->get_query_unica('SELECT * FROM licencas WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/licencas');
    exit;
  }
} elseif(isset($_POST['var3']) AND trim($_POST['var3']) === 'deletar'){
  $page_start = 'deletar';
  $current_row = $classesWeb->get_query_unica('SELECT * FROM licencas WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/licencas');
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
                    $buscar_licencas = $classesWeb->busca_licencas(); 
                     ?>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-6">
                                    <h3>Home</h3>
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
                            <div class="card-header">
                              <h5>Licenças
                                <?php 
                                if($_SESSION['usuario'][2] == 'Gestor' || $_SESSION['usuario'][2] == 'Administrador')
                                {
                                 ?><a href="<?php echo WEBURL;?><?php echo $_POST["var1"];?>/<?php echo $_POST["var2"];?>/cadastro" class="btn-add btn-primary"><i data-feather="plus"></i></a>
                                <?php 
                                }
                                ?>
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
                                  <thead>
                                    <tr>
                                      <th>Orgão Regulador</th>
                                      <th>Licença</th>
                                      <th>Data de Emissão</th>
                                      <th>Vencimento</th>
                                      <th>Status</th>
                                      <th>#</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <?php if(!empty($buscar_licencas)) { ?>
                                        <?php 
                                         foreach($buscar_licencas as $LICENCAS) { 
                                            ?>
                                            <tr>
                                              <td><?php echo $LICENCAS->orgao_regulador ?></td>
                                              <td><?php echo $LICENCAS->nome_licenca ?></td>
                                              <td><?php echo $LICENCAS->dt_emissao ?></td>
                                              <td><?php echo $LICENCAS->dt_vencimento ?></td>
                                              <td><?php echo $USUARIOS->status ?></td>
                                              <td>
                                                <div class="dropdown dropdown-item-table">
                                                  <button type="button" class="btn btn-primary dropbtn dropdown-toggle dropdown-datatable p-2" data-toggle="dropdown"></button>
                                                  <div class="dropdown-menu">
                                                      <a class="dropdown-item" href="<?php echo WEBURL . 'gerenciamento/licencas/edicao' . $LICENCAS->hash ?>">Ver/Editar</a>
                                                      <a class="dropdown-item" href="#" data-delete-item="hash" data-delete-table="licencas" data-delete-parameter="" data-delete-message="">Excluir</a>
                                                  </div>
                                                </div>
                                              </td>
                                            </tr>
                                        <?php } ?>
                                      <?php } ?>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                    <th>Orgão Regulador</th>
                                      <th>Licença</th>
                                      <th>Data de Emissão</th>
                                      <th>Vencimento</th>
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
                            <div class="col-12">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL; ?>"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Gerenciamento</li>
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL . 'gerenciamento/licencas' ?>">Licenças</a></li>
                                <li class="breadcrumb-item"><?php echo ($page_start === 'cadastro' ? 'cadastro' : 'edicao') ?></li>
                              </ol>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                      <form id="form-licencas" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL;?>php/modulos/licencas/administrador/code/ajax-licencas.php?action_type=gestao_licencas&type=<?php echo ($page_start === 'cadastro' ? 'new' : 'edit')?>&key=<?php echo ($page_start === 'cadastro' ? '' : $current_row->hash) ?>" method="POST">
                        <div class="col-sm-12">
                          <div class="card">
                            <div class="card-header">
                                <h5>Cadastro de Licenças</h5>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12 mb-3">
                                  <label>Selecione uma categoria de licença</label>
                                  <select class="form-control field-required col-md-12" id="hierarquia" name="hierarquia" required="">
                                    <option value="" selected>-- Selecione uma categoria --</option>
                                    <option value="3">IBAMA</option>
                                    <option value="2">SEMAE</option>
                                    <option value="1">CETESB</option>
                                    <option value="1">DAEE</option>
                                    <option value="1">SIVISA</option>
                                    <option value="1">POLÍCIA CIVIL</option>
                                  </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="orgao_regulador">Orgão Regulador</label>
                                  <input type="text" class="form-control" name="orgao_regulador" placeholder="Informe o orgão regulador" value="<?php echo (isset($current_row->nome_completo) ? $current_row->nome_completo : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-6 mb-3">
                                  <label for="nome_licenca">Nome da Licença</label>
                                  <input type="text" class="form-control" name="nome_licenca" placeholder="Informe o nome da licença" value="<?php echo (isset($current_row->nome_tratativa) ? $current_row->nome_tratativa : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="num_documento">Nº do Documento</label>
                                  <input type="email" class="form-control" name="email" placeholder="Nº do Documento" value="<?php echo (isset($current_row->email) ? $current_row->email : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="dt_emissao">Data de Emissão</label>
                                  <input type="email" class="form-control" name="dt_emissao" placeholder="Inserir date-picker aqui" value="<?php echo (isset($current_row->email) ? $current_row->email : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="dt_vecimento">Data de Vencimento</label>
                                  <input type="email" class="form-control" name="dt_vencimento" placeholder="Inserir date-picker aqui" value="<?php echo (isset($current_row->email) ? $current_row->email : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="taxa_emissao">Taxa de Emissão</label>
                                  <input type="email" class="form-control" name="taxa_emissao" placeholder="R$0,00" value="<?php echo (isset($current_row->email) ? $current_row->email : '') ?>" autocomplete="off" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="taxa_renovacao">Taxa de Renovação</label>
                                  <input type="email" class="form-control" name="taxa_renovacao" placeholder="R$0,00" value="<?php echo (isset($current_row->email) ? $current_row->email : '') ?>" autocomplete="off" required="">
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
          'management'
        ));
        ?>  
    </body>
</html>