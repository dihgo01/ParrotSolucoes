<?php

if (isset($_POST['var2'])) {
    switch ($_POST['var2']) {
        case 'clientes-erp':
            include_once 'modulos/clientes-erp/administrador/clientes-erp.php';
            break;
        default:
            break;
    }
}

if (isset($_POST['var2'])) {
    switch ($_POST['var2']) {
        case 'usuarios':
            include_once 'modulos/usuarios/administrador/usuarios.php';
            break;
        default:
            break;
    }
}

if (isset($_POST['var2'])) {
    switch ($_POST['var2']) {
        case 'licencas':
            include_once 'modulos/licencas/administrador/licencas.php';
            break;
        default:
            break;
    }
}

if (isset($_POST['var2'])) {
    switch ($_POST['var2']) {
        case 'clientes':
            include_once 'modulos/clientes/administrador/clientes.php';
            break;
        default:
            break;
    }
}

if (isset($_POST['var2'])) {
    switch ($_POST['var2']) {
        case 'fornecedores':
            include_once 'php/modulos/fornecedores/administrador/fornecedores-erp.php';
            break;
        default:
            break;
    }
}

if (isset($_POST['var2'])) {
    switch ($_POST['var2']) {
        case 'funcionarios':
            include_once 'php/modulos/funcionarios/administrador/funcionarios.php';
            break;
        default:
            break;
    }
}

if (isset($_POST['var2'])) {
    switch ($_POST['var2']) {
        case 'produtos':
            include_once 'php/modulos/produtos/administrador/produtos.php';
            break;
        default:
            break;
    }
}

if (isset($_POST['var2'])) {
    switch ($_POST['var2']) {
        case 'cargos':
            include_once 'php/modulos/cargos/administrador/cargos.php';
            break;
        default:
            break;
    }
}

