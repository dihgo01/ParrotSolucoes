<?php

if (!isset($_SESSION)) {
    session_start();
}

$getURL = explode('/', $_SERVER['REQUEST_URI']);
include_once 'variaveis-aplicacao.php';

if (sizeof($getURL) > 1) {
    $pagina_active = $getURL[1];
    $_POST['var1'] = $getURL[1];
}

if (sizeof($getURL) > 2) {
    $_POST['var2'] = $getURL[2];
}

if (sizeof($getURL) > 3) {
    $_POST['var3'] = $getURL[3];
}

if (sizeof($getURL) > 4) {
    $_POST['var4'] = $getURL[4];
}

if (sizeof($getURL) > 5) {
    $_POST['var5'] = $getURL[5];
}

if (sizeof($getURL) > 6) {
    $_POST['var6'] = $getURL[6];
}

$permissao = array('', 'home', 'sair', 'gerenciamento', 'dashboard');

if (trim($pagina_active) !== '') {
    include_once 'code/validations.php';
}

switch ($pagina_active) {
    case '':
        $destiny = '/php/login.php';
        break;
    case 'dashboard':
        $destiny = '/php/home.php';
    case 'home':
        $destiny = '/php/home.php';
        break;
    case 'sair':
        session_destroy();
        header('Location: /login');
        exit;
        break;
    case 'gerenciamento':
        $destiny = '/php/rotas.php';
        break;
    default:
        $destiny = '/php/login.php';
        break;
}

if (in_array($pagina_active, $permissao)) {
    include_once $_SERVER['DOCUMENT_ROOT'] . $destiny;
} else {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/login.php';
}
