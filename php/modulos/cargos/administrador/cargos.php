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
  $current_row = $classesWeb->get_query_unica('SELECT * FROM cargos WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/cargos');
    exit;
  }
} elseif(isset($_POST['var3']) AND trim($_POST['var3']) === 'deletar'){
  $page_start = 'deletar';
  $current_row = $classesWeb->get_query_unica('SELECT * FROM cargos WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/cargos');
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
            <!-- Page Header Ends -->
            <!-- Page Body Start-->
            <div class="page-body-wrapper">
                <!-- Page Sidebar Start-->
                <?php include_once ROOT . 'php/includes/sidebar-menu.php'; ?>
                <!-- Page Sidebar Ends-->
                <div class="page-body">
                  <?php 
                  if($page_start === 'listagem') {
                    $buscar_cargos = $classesWeb->busca_cargos(); 
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
                              <h5>Cargos 
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
                                  <thead class="text-center">
                                    <tr>
                                      <th>Nome do Cargo</th>
                                      <th>CBO</th>
                                      <th>Subordinados</th>
                                      <th>Superiores</th>
                                      <th>Requisitos Mínimos</th>
                                      <th>Requisitos Desejáveis</th>
                                      <th>Data da Última Revisão</th>
                                      <th>#</th>
                                    </tr>
                                  </thead>
                                  <tbody class="text-center">
                                    <?php if(!empty($buscar_cargos)) { ?>
                                      <?php 
                                        foreach($buscar_cargos as $CARGOS) { 
                                          ?>
                                          <tr>
                                            <td><?php echo $CARGOS->nome_cargo ?></td>
                                            <td><?php echo $CARGOS->cbo ?></td>
                                            <td><?php echo $CARGOS->subordinados ?></td>
                                            <td><?php echo $CARGOS->superiores ?></td>
                                            <td><?php echo $CARGOS->requisitos_minimos ?></td>
                                            <td><?php echo $CARGOS->requisitos_desejados ?></td>
                                            <td><?php echo $CARGOS->dt_atualizacao ?></td>
                                            <td>
                                              <div class="dropdown dropdown-item-table">
                                                  <button type="button" class="btn btn-primary dropbtn dropdown-toggle dropdown-datatable p-2" data-toggle="dropdown"><i class="icofont icofont-arrow-down"></i></button>
                                                  <div class="dropdown-menu">
                                                      <a class="dropdown-item" href="<?php echo WEBURL . 'gerenciamento/cargos/edicao/' . $CARGOS->hash ?>">Ver/Editar</a>
                                                      <a class="dropdown-item" href="#" data-delete-item="<?php echo $CARGOS->hash ?>" data-delete-table="cargos" data-delete-parameter="hash" data-delete-message="Têm certeza que deseja que deseja excluir este cargo? Caso opte por sim não poderá recuperá-lo">Excluir</a>
                                                  </div>
                                                </div>
                                            </td>
                                          </tr>
                                      <?php } ?>
                                    <?php } ?>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <th>Nome do Cargo</th>
                                      <th>CBO</th>
                                      <th>Subordinados</th>
                                      <th>Superiores</th>
                                      <th>Requisitos Mínimos</th>
                                      <th>Requisitos Desejados</th>
                                      <th>Data da Última Revisão</th>
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
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL . 'gerenciamento/clientes' ?>">Funcionários</a></li>
                                <li class="breadcrumb-item"><?php echo ($page_start === 'cadastro' ? 'cadastro' : 'edicao') ?></li>
                              </ol>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                      <form id="form-cargos" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL;?>php/modulos/cargos/administrador/code/ajax-cargos.php?action_type=gestao_cargos&type=<?php echo ($page_start === 'cadastro' ? 'new' : 'edit')?>&key=<?php echo ($page_start === 'cadastro' ? '' : $current_row->hash) ?>" method="POST">
                        <div class="col-sm-12">
                          <div id="card-usuario" class="card">
                            <div class="card-body">
                              <div class="row">
                                <div id="usuarios" class="col-md-12">
                                  <div id="usuario-externo">
                                    <h5 class="mb-5">Cadastro de Cargos</h5> <br>
                                    <div class="row">
                                      <h6 class="mb-4">Descrição de Cargos</h6> <br>
                                      <div class="col-md-9 mb-3">
                                        <label for="nome_cargo">Nome do Cargo</label>
                                        <input type="text" class="form-control" name="nome_cargo" placeholder="Informe o nome completo do cargo" value="<?php echo (isset($current_row->nome_cargo) ? $current_row->nome_cargo : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-3 mb-3">
                                        <label for="cbo">CBO</label>
                                        <input type="text" class="form-control field-cbo" name="cbo" placeholder="XXXXXX" value="<?php echo (isset($current_row->cbo) ? $current_row->cbo : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-12 mb-3">
                                        <label for="descricao">Descrição</label>
                                        <textarea type="text" class="form-control" name="descricao" placeholder="Descreva o objetivo do cargo" value="" autocomplete="off" required=""><?php echo (isset($current_row->descricao) ? $current_row->descricao : '') ?></textarea>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                        <label for="subordinados">Subordinados</label>
                                        <input type="text" class="form-control" name="subordinados" placeholder="Informe os subordinados deste cargo" value="<?php echo (isset($current_row->subordinados) ? $current_row->subordinados : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-6 mb-3">
                                        <label for="superiores">Superiores</label>
                                        <input type="text" class="form-control" name="superiores" placeholder="Informe os superiores deste cargo" value="<?php echo (isset($current_row->superiores) ? $current_row->superiores : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-6 mb-3">
                                        <label for="requisitos_minimos">Requisitos Mínimos</label>
                                        <input type="text" class="form-control" name="requisitos_minimos" placeholder="Informe os superiores deste cargo" value="<?php echo (isset($current_row->requisitos_minimos) ? $current_row->requisitos_minimos : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-6 mb-3">
                                        <label for="requisitos_desejados">Requisitos Desejados</label>
                                        <input type="text" class="form-control" name="requisitos_desejados" placeholder="Informe os superiores deste cargo" value="<?php echo (isset($current_row->requisitos_desejados) ? $current_row->requisitos_desejados : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-12 mb-3">
                                        <label for="atividades_executadas">Atividades Exercidas</label>
                                        <textarea type="text" class="form-control" name="atividades_executadas" placeholder="Descreva as atividades exercidas" autocomplete="off" required=""><?php echo (isset($current_row->atividades_executadas) ? $current_row->atividades_executadas : '') ?></textarea>
                                      </div>
                                      <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit"><?php echo ($page_start === 'cadastro' ? 'Cadastrar' : 'Atualizar') ?></button>
                                      </div>
                                    </div>
                                  </div>
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
          'mask',
          'select2'
        ));
        ?>  
        <script src="<?php echo WEBURL ?>php/modulos/funcionarios/administrador/code/js/funcionarios.js"></script>
    </body>
</html>