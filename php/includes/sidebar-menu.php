<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="<?php echo WEBURL ?>">
                <img class="img-fluid for-light" src="<?php echo WEBURL ?>assets/images/logo/logo.png" alt="" style="height: 30px">
                <img class="img-fluid for-dark" src="<?php echo WEBURL ?>assets/images/logo/logo_dark.png" alt="" style="height: 30px">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="<?php echo WEBURL ?>">
                <img class="img-fluid" src="<?php echo WEBURL ?>assets/images/logo/logo-icon.png" width="32" alt="">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="<?php echo WEBURL ?>">
                            <img class="img-fluid" src="<?php echo WEBURL ?>assets/images/logo/logo-icon.png" width="32" alt="">
                        </a>
                        <div class="mobile-back text-end"><span>Voltar</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">Minha Empresa</h6>
                            <p class="">Módulos de Gestão de Empresa</p>
                        </div>
                    </li>

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="<?php echo WEBURL ?>dashboard"><i data-feather="home"></i><span>Dashboard</span></a></li>
                    <!--                    <li class="sidebar-list">
                                            <label class="badge badge-info">BREVE</label>
                                            <a class="sidebar-link sidebar-title" href="#">
                                                <i data-feather="pie-chart"></i><span class="">Marketing</span>
                                            </a>
                                           <ul class="sidebar-submenu">
                                                <li><a class="submenu-title" href="#">Pedidos<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                                                    <ul class="nav-sub-childmenu submenu-content">
                                                        <li><a href="#">Consultar</a></li>
                                                        <li><a href="#">Novo</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                    </li>-->
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">Sistema Gestor</h6>
                            <p class="">Módulos de Gestão de Módulos</p>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="user-check"></i><span class="">Clientes ERP</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo WEBURL ?>gerenciamento/clientes-erp">Lista de Clientes ERP</a></li>
                            <li><a href="<?php echo WEBURL ?>gerenciamento/clientes-erp/cadastro">Novo Cliente ERP</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="users"></i><span class="">Clientes</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo WEBURL ?>gerenciamento/clientes">Lista de Clientes ERP</a></li>
                            <li><a href="<?php echo WEBURL ?>gerenciamento/clientes/cadastro">Novo Cliente ERP</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="truck"></i><span class="">Fornecedores</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo WEBURL ?>gerenciamento/fornecedores">Lista de Fornecedores</a></li>
                            <li><a href="<?php echo WEBURL ?>gerenciamento/fornecedores/cadastro">Novo Fornecedor</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="users"></i><span class="">Usuários</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo WEBURL ?>gerenciamento/usuarios">Listar Usuários ERP</a></li>
                            <?php if ($_SESSION['usuario']['SESS_USER_HIERARQUIA'] == 'Gestor' || $_SESSION['usuario']['SESS_USER_HIERARQUIA'] == 'Administrador') {
                            ?>
                                <li><a href="<?php echo WEBURL ?>gerenciamento/usuarios/cadastro">Novo Usuário ERP</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="package"></i><span class="">Produtos</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo WEBURL ?>gerenciamento/produtos">Lista de Produtos</a></li>
                            <li><a href="<?php echo WEBURL ?>gerenciamento/produtos/cadastro">Novo Produto</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="user"></i><span class="">Funcionários</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo WEBURL ?>gerenciamento/funcionarios">Listar Funcionários</a></li>
                            <li><a href="<?php echo WEBURL ?>gerenciamento/funcionarios/cadastro">Novo Funcionário</a></li>
                            <li><a href="<?php echo WEBURL ?>gerenciamento/cargos/">Listar Cargos</a></li>
                            <li><a href="<?php echo WEBURL ?>gerenciamento/cargos/cadastro">Cadastrar Cargo</a></li>
                        </ul>
                    </li>

                    <!-- <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="award"></i><span class="">Licenças</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="<?php echo WEBURL ?>gerenciamento/licencas">Listar Licenças</a></li>
                            <?php if ($_SESSION['usuario'][2] == 'Gestor' || $_SESSION['usuario'][2] == 'Administrador') {
                            ?>
                            <li><a href="<?php echo WEBURL ?>gerenciamento/licencas/cadastro">Nova Licença ERP</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li> -->

                    <li class="sidebar-list">&nbsp;</li>
                    <li class="sidebar-list">&nbsp;</li>
                    <li class="sidebar-list">&nbsp;</li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>