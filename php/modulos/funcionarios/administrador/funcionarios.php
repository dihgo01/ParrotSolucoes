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
  $current_row = $classesWeb->get_query_unica('SELECT * FROM funcionarios WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/funcionarios');
    exit;
  }
} elseif(isset($_POST['var3']) AND trim($_POST['var3']) === 'deletar'){
  $page_start = 'deletar';
  $current_row = $classesWeb->get_query_unica('SELECT * FROM funcionarios WHERE hash="' . $_POST['var4'] . '"AND status <> "Inativo"');
  if(empty($current_row))
  {
    header('Location: /gerenciamento/funcionarios');
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
                    $buscar_funcionarios = $classesWeb->busca_funcionarios(); 
                     ?>
                    <div class="container-fluid">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-6">
                                    <h3>Listar Funcionários</h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo WEBURL ?>"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item">Gerenciamento</li>
                                        <li class="breadcrumb-item">Funcionários</li>
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
                                Funcionários
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
                                      <th>Nome</th>
                                      <th>CPF</th>
                                      <th>E-mail</th>
                                      <th>Telefone</th>
                                      <th>Data de Admissão</th>
                                      <th>Status</th>
                                      <th>#</th>
                                    </tr>
                                  </thead>
                                  <tbody class="text-center">
                                    <?php if(!empty($buscar_funcionarios)) { ?>
                                      <?php 
                                        foreach($buscar_funcionarios as $FUNCIONARIOS) { 
                                          ?>
                                          <tr>
                                            <td><?php echo $FUNCIONARIOS->nome_completo ?></td>
                                            <td><?php echo $FUNCIONARIOS->cpf ?></td>
                                            <td><?php echo $FUNCIONARIOS->email ?></td>
                                            <td><?php echo $FUNCIONARIOS->telefone ?></td>
                                            <td><?php echo $FUNCIONARIOS->dt_admissao ?></td>
                                            <td><?php if($FUNCIONARIOS->status === 'Ativo') 
                                              {
                                                  echo "<label class='badge badge-success'>$FUNCIONARIOS->status</label>";
                                              } elseif ($FUNCIONARIOS->status === 'Bloqueado') {
                                                echo "<label class='badge badge-danger'>$FUNCIONARIOS->status</label>";
                                              }
                                              ?></td>
                                            <td>
                                              <div class="dropdown dropdown-item-table">
                                                  <button type="button" class="btn btn-primary dropbtn dropdown-toggle dropdown-datatable p-2" data-toggle="dropdown"><i class="icofont icofont-arrow-down"></i></button>
                                                  <div class="dropdown-menu">
                                                      <a class="dropdown-item" href="<?php echo WEBURL . 'gerenciamento/funcionarios/edicao/' . $FUNCIONARIOS->hash ?>">Ver/Editar</a>
                                                      <a class="dropdown-item" href="#" data-delete-item="<?php echo $FUNCIONARIOS->hash ?>" data-delete-table="funcionarios" data-delete-parameter="hash" data-delete-message="Têm certeza que deseja que deseja excluir este funcionário? Caso opte por sim não poderá recuperá-lo">Excluir</a>
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
                                      <th>E-mail</th>
                                      <th>Data de Admissão</th>
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
                              <h3><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'Edição') ?> de Funcionários</h3>
                            </div>
                            <div class="col-6">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL; ?>"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">Gerenciamento</li>
                                <li class="breadcrumb-item"><a href="<?php echo WEBURL . 'gerenciamento/funcionarios' ?>">Funcionários</a></li>
                                <li class="breadcrumb-item"><?php echo ($page_start === 'cadastro' ? 'Cadastro' : 'edicao') ?></li>
                              </ol>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                      <form id="form-funcionarios" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL;?>php/modulos/funcionarios/administrador/code/ajax-funcionarios.php?action_type=gestao_funcionarios&type=<?php echo ($page_start === 'cadastro' ? 'new' : 'edit')?>&key=<?php echo ($page_start === 'cadastro' ? '' : $current_row->hash) ?>" method="POST">
                        <div class="col-sm-12">
                          <div id="card-usuario" class="card">
                            <div class="card-body">
                              <div class="row">
                                <div id="usuarios" class="col-md-12">
                                  <div id="usuario-externo">
                                   
                                    <div class="row">
                                      <h6 class="mb-4">Dados Cadastrais</h6> <br>
                                      <div class="col-md-4 mb-3">
                                        <label for="nome_completo">Nome Completo</label>
                                        <input type="text" class="form-control select2" name="nome_completo" placeholder="Informe o nome completo" value="<?php echo (isset($current_row->nome_completo) ? $current_row->nome_completo : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-4 mb-3">
                                        <label for="nome_tratativa">Nome Tratativa</label>
                                        <input type="text" class="form-control" name="nome_tratativa" placeholder="Informe o nome de tratativa do funcionário" value="<?php echo (isset($current_row->nome_tratativa) ? $current_row->nome_tratativa : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-4 mb-3">
                                        <label for="cpf">CPF</label>
                                        <input type="text" class="form-control field-cpf search-cpf" name="cpf" placeholder="CPF" value="<?php echo (isset($current_row->cpf) ? $current_row->cpf : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <?php 
                                      if(isset($_POST['cpf']))
                                      { 
                                        $buscar_funcionarios = busca_funcionarios_por_cpf($_POST['cpf']);
                                        var_dump($buscar_funcionarios);
                                      }?>
                                      <div class="col-md-2 mb-3">
                                        <label for="rg">RG</label>
                                        <input type="text" class="form-control select2" name="rg" placeholder="RG" value="<?php echo (isset($current_row->rg) ? $current_row->rg : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-2 mb-3">
                                        <label for="dt_nascimento">Data de Nascimento</label>
                                        <input type="text" class="field-get-date form-control field-date" data-language="en" name="dt_nascimento" placeholder="__/__/____" value="<?php echo (isset($current_row->dt_nascimento) ? implode('/', array_reverse(explode('-', $current_row->dt_nascimento))) : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-4 mb-3">
                                        <label for="telefone">Telefone</label>
                                        <input type="text" class="form-control field-phone" name="telefone" placeholder="Informe o telefone com DDD" value="<?php echo (isset($current_row->telefone) ? $current_row->telefone : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-4 mb-3">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control field-phone" name="celular" placeholder="Informe o celular com DDD" value="<?php echo (isset($current_row->celular) ? $current_row->celular : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-3 mb-3">
                                        <label for="nome_contato_emergencia">Nome do Contato de Emergência</label>
                                        <input type="text" class="form-control" name="nome_contato_emergencia" placeholder="Informe o nome de um contato de emergência" value="<?php echo (isset($current_row->nome_contato_emergencia) ? $current_row->nome_contato_emergencia : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-3 mb-3">
                                        <label for="tel_emergencia">Telefone do Contato de Emergência</label>
                                        <input type="text" class="form-control field-phone" name="tel_emergencia" placeholder="Informe o telefone com DDD" value="<?php echo (isset($current_row->tel_emergencia) ? $current_row->tel_emergencia : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-3 mb-3">
                                        <label for="email">E-mail</label>
                                        <input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo (isset($current_row->tel_emergencia) ? $current_row->tel_emergencia : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-3 mb-5">
                                        <label>Estado Civil</label>
                                        <select class="form-control field-required col-md-12" id="estado_civil" name="estado_civil" required="">
                                          <option value="<?php if($page_start === 'edicao') { 
                                            echo (isset($current_row->estado_civil) ? $current_row->estado_civil : ''); }?>" selected>
                                            <?php if($page_start === 'edicao') { 
                                            echo (isset($current_row->estado_civil) ? $current_row->estado_civil : ''); } else {
                                            echo "Selecione";
                                            }
                                            ?> </option>
                                          <?php 
                                            $estado_civil = $classesWeb->busca_estado_civil();
                                            if (!empty($estado_civil))
                                            {
                                              foreach($estado_civil as $CIVIL) {
                                              ?> <option> <?php echo $CIVIL->descricao ?> </option>
                                              <?php } 
                                            } 
                                          ?>
                                        </select>
                                      </div>
                                      <h6 class="mb-3">Endereço</h6>
                                      <div class="col-md-2 mb-3">
                                        <label for="cep">CEP</label>
                                        <input type="text" class="form-control search-cep field-cep" name="cep" placeholder="CEP" value="<?php echo (isset($current_row->cep) ? $current_row->cep : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-6 mb-3">
                                        <label for="logradouro">Endereço</label>
                                        <input type="text" class="form-control" name="logradouro" placeholder="Endereço" value="<?php echo (isset($current_row->logradouro) ? $current_row->logradouro : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-1 mb-3">
                                        <label for="num_endereco">Nº</label>
                                        <input type="text" class="form-control" name="num_endereco" placeholder="123" value="<?php echo (isset($current_row->numero) ? $current_row->numero : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-3 mb-3">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" class="form-control" name="complemento" placeholder="Apto., bloco, quadra, lote etc." value="<?php echo (isset($current_row->complemento) ? $current_row->complemento : '') ?>" autocomplete="off">
                                      </div>
                                      <div class="col-md-3 mb-3">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" class="form-control" name="bairro" placeholder="Bairro" value="<?php echo (isset($current_row->bairro) ? $current_row->bairro : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <div class="col-md-3 mb-3">
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
                                      <div class="col-md-3 mb-3">
                                        <label class="col-form-label" for="inputState">Estado</label>
                                        <select class="form-control data-estado select2" name="estado" id="estado" placeholder="Selecione" required="">
                                          <option value="<?php if($page_start === 'edicao') { 
                                          echo (isset($current_row->estado) ? $current_row->estado : ''); }?>" selected>
                                          <?php if($page_start === 'edicao') { 
                                          echo (isset($current_row->estado) ? $current_row->estado : ''); } else {
                                          echo "Selecione";
                                          }
                                          ?> </option>
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
                                      <div class="col-md-3  mb-5">
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
                                      </div> <br>
                                      
                                      <h6 class="mb-3">Funções</h6>
                                      <div class="col-md-6 mb-3">
                                        <label for="funcao">Função</label>
                                        <input type="text" class="form-control" name="funcao" placeholder="<-- Selecione uma função -->" value="<?php echo (isset($current_row->funcao) ? $current_row->funcao : '') ?>" autocomplete="off" required="">
                                      </div>
                                      <!-- <div class="col-md-6 mb-3">
                                        <label for="carga_horaria">Carga Horária</label>
                                        <input type="text" class="form-control" name="carga_horaria" placeholder="Selecione um cargo" value="<?php //echo (isset($current_row->complemento) ? $current_row->complemento : '') ?>" autocomplete="off" required="">
                                      </div> -->
                                      <div class="col-md-6 mb-5">
                                        <label for="dt_admissao">Data de Admissão</label>
                                        <input type="text" class="form-control field-date field-get-date" name="dt_admissao" placeholder="__/__/____" value="<?php echo (isset($current_row->dt_admissao) ? implode('/', array_reverse(explode('-', $current_row->dt_admissao))) : '') ?>" autocomplete="off" required="">
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
        <!--<script src="<?php //echo WEBURL ?>php/modulos/funcionarios/administrador/code/js/funcionarios.js"></script> -->
    </body>
</html>