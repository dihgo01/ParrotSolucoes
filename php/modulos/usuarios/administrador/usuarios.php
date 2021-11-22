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
  $current_row = $classesWeb->get_query_unica('SELECT * FROM usuarios WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/usuarios');
    exit;
  }
} elseif(isset($_POST['var3']) AND trim($_POST['var3']) === 'deletar'){
  $page_start = 'deletar';
  $current_row = $classesWeb->get_query_unica('SELECT * FROM usuarios WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/usuarios');
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
                    $buscar_usuarios_erp = $classesWeb->busca_usuarios_erp(); 
                     ?>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-6">
                                    <h3>Listar Usuários</h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL ?>"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item">Gerenciamento</li>
                                        <li class="breadcrumb-item">Usuários</li>
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
                                Usuários
                                <a href="<?php echo WEBURL ?><?php echo $_POST['var1'] ?>/<?php echo $_POST['var2'] ?>/cadastro" class="btn-add btn-primary"><i data-feather="plus"></i></a>
                            </h5>
                            </div>
                            <div class="card-body pt-0">
                              <div class="text-center mt-3 loader-datatable">
                                <div class="loader-box">
                                    <div class="loader-3"></div>
                                </div>
                              </div>
                              <div class="start-datatable-element">
                                <table class="display datatables start-datatable">
                                  <thead class="text-center">
                                    <tr>
                                      <th>Hierarquia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Tipo de Usuário</th>
                                      <th>Status</th>
                                      <th>#</th>
                                    </tr>
                                  </thead>
                                  <tbody class="text-center">
                                      <?php if(!empty($buscar_usuarios_erp)) { ?>
                                        <?php 
                                         foreach($buscar_usuarios_erp as $USUARIOS) { 
                                            ?>
                                            <tr>
                                              <td><?php echo $USUARIOS->hierarquia ?></td>
                                              <td><?php echo $USUARIOS->nome_tratativa ?></td>
                                              <td><?php echo $USUARIOS->email ?></td>
                                              <td><?php echo $USUARIOS->tipo_usuario ?></td>
                                              <td><?php if($USUARIOS->status === 'Ativo') 
                                              {
                                                  echo "<label class='badge badge-success'>$USUARIOS->status</label>";
                                              } elseif ($USUARIOS->status === 'Bloqueado') {
                                                echo "<label class='badge badge-danger'>$USUARIOS->status</label>";
                                              }
                                              ?></td>
                                              <td>
                                                <div class="dropdown dropdown-item-table">
                                                  <button type="button" class="btn btn-primary dropbtn dropdown-toggle dropdown-datatable p-2" data-toggle="dropdown"><i class="icofont icofont-arrow-down"></i></button>
                                                  <div class="dropdown-menu">
                                                      <a class="dropdown-item" href="<?php echo WEBURL . 'gerenciamento/usuarios/edicao/' . $USUARIOS->hash ?>">Ver/Editar</a>
                                                      <a class="dropdown-item" href="#" data-delete-item="<?php echo $USUARIOS->hash ?>" data-delete-table="usuarios" data-delete-parameter="hash" data-delete-message="Excluíndo este item, não será possível recuperá-lo posteriormente. Tem certeza que deseja excluí-lo?">Excluir</a>
                                                  </div>
                                                </div>
                                              </td>
                                            </tr>
                                        <?php } ?>
                                      <?php } ?>
                                  </tbody>
                                  <tfoot class="text-center">
                                    <tr>
                                      <th>Hierarquia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Tipo de Usuário</th>
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
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL . 'gerenciamento/usuarios' ?>">Usuários</a></li>
                                <li class="breadcrumb-item"><?php echo ($page_start === 'cadastro' ? 'cadastro' : 'edicao') ?></li>
                              </ol>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                      <div class="col-sm-12">
                        <div id="card-usuario" class="card">
                          <div class="card-body">
                            <div class="row">
                              <div id="usuarios" class="col-md-12">
                                <form id="form-usuarios-externos" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL;?>php/modulos/usuarios/administrador/code/ajax-usuarios.php?action_type=gestao_usuarios&type=<?php echo ($page_start === 'cadastro' ? 'new' : 'edit')?>&key=<?php echo ($page_start === 'cadastro' ? '' : $current_row->hash) ?>" method="POST">
                                  <h5><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'Edição') ?> de Usuários</h5> <br>
                                  <div class="row">
                                  <div class="col-md-3 mb-3">
                                    <label>Selecione um Tipo de Usuário</label>
                                    <select class="form-control field-required col-md-12" id="tipo" name="tipo" required="">
                                      <option value="" >Selecione</option>
                                      <option value="Funcionário" <?php if($page_start === 'edicao'){ 
                                        echo ($current_row->tipo_usuario === "Funcionário" ? 'selected' : '');}?>>Funcionário</option>
                                      <option value="Terceiro" <?php if($page_start === 'edicao'){
                                        echo ($current_row->tipo_usuario === "Terceiro" ? 'selected' : '');}?>>Terceiro</option>
                                      <option value="Cliente" <?php if($page_start === 'edicao'){
                                        echo ($current_row->tipo_usuario === "Cliente" ? 'selected' : '');}?>>Cliente</option>
                                      <option value="Fornecedor" <?php if($page_start === 'edicao'){
                                        echo ($current_row->tipo_usuario === "Fornecedor" ? 'selected' : '');}?>>Fornecedor</option>
                                    </select>
                                  </div>
                                  <div class="col-md-3 mb-3">
                                      <label for="nome_completo">Nome Completo</label>
                                      <input type="text" class="form-control" name="nome_completo" placeholder="Nome Completo" value="<?php echo (isset($current_row->nome_completo) ? $current_row->nome_completo : '') ?>" autocomplete="off" required="">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                      <label for="nome_tratativa">Nome Tratativa</label>
                                      <input type="text" class="form-control" name="nome_tratativa" placeholder="Nome Completo" value="<?php echo (isset($current_row->nome_tratativa) ? $current_row->nome_tratativa : '') ?>" autocomplete="off" required="">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                      <label for="email">E-mail</label>
                                      <input type="email" class="form-control" name="email" placeholder="E-mail" value="<?php echo (isset($current_row->email) ? $current_row->email : '') ?>" autocomplete="off" required="">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                      <label for="primeiro_telefone">Telefone</label>
                                      <input type="text" class="form-control field-phone" name="telefone" placeholder="Informe o telefone com DDD" value="<?php echo (isset($current_row->telefone) ? $current_row->telefone : '') ?>" autocomplete="off" required="">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                      <label for="empresa">Empresa</label>
                                      <select class="form-control field-required col-md-12" id="empresa"  name="empresa" required="" selected>
                                        <option value="<?php if($page_start === 'edicao') { 
                                        echo (isset($current_row->empresa) ? $current_row->empresa : ''); }?>" selected>
                                        <?php if($page_start === 'edicao') { 
                                        echo (isset($current_row->empresa) ? $current_row->empresa : ''); } else {
                                        echo "Selecione";
                                        }
                                        ?> </option>
                                        <?php 
                                        $empresa = $classesWeb->busca_empresa();
                                        if (!empty($empresa))
                                        {
                                        foreach($empresa as $EMPRESA) {
                                        ?> <option> <?php echo $EMPRESA->razao_social ?> </option>
                                        <?php } 
                                        } 
                                        ?>
                                      </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                      <label>Selecione um Tipo de Acesso</label>
                                      <select class="form-control field-required col-md-12" id="hierarquia" name="hierarquia" required="">
                                        <option value="" selected>Selecione</option>
                                        <option value="Funcionario" <?php if($page_start === 'edicao'){ 
                                            echo ($current_row->hierarquia === "Funcionário" ? 'selected' : '');}?>>Funcionário</option>
                                        <option value="Gestor" <?php if($page_start === 'edicao'){ 
                                            echo ($current_row->hierarquia === "Gestor" ? 'selected' : '');}?>>Gestor</option>
                                        <option value="Administrador" <?php if($page_start === 'edicao'){ 
                                            echo ($current_row->hierarquia === "Administrador" ? 'selected' : '');}?>>Administrador</option>
                                      </select>
                                    </div>
                                    <div class="col-md-3 mb-5" <?php if($page_start === 'edicao') { echo 'hidden'; }?>>
                                      <label for="senha">Senha</label>
                                      <input type="password" class="form-control" name="senha" placeholder="********" value="<?php echo (isset($current_row->senha) ? md5($current_row->senha) : '') ?>" autocomplete="off" <?php echo ($page_start === 'edicao' ? '' : 'required=""') ?>>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit"><?php echo ($page_start === 'cadastro' ? 'Cadastrar' : 'Atualizar') ?></button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
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
                                <div class="col-md-6 mb-5">
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
    </body>
</html>