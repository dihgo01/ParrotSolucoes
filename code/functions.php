<?php
if(!isset($_SESSION)) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/variaveis-aplicacao.php';

function gerar_cabecalho($titulo_pagina = 'ERP Inteligente - Parrot Soluções') {
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo WEBURL ?>assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo WEBURL ?>assets/images/favicon.png" type="image/x-icon">
    <title><?php echo $titulo_pagina ?></title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/fontawesome.min.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?php echo WEBURL ?>assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo WEBURL ?>assets/css/responsive.css">
    <?php
}

function gerar_css($plugins = array()) {
    if (!empty($plugins)) {
        foreach ($plugins as $LOAD_PLUGINS) {
            switch ($LOAD_PLUGINS) {
                case 'chartlist':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/chartist.css">';
                    break;
                case 'owlcarousel':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/owlcarousel.css">';
                    break;
                case 'prism':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/prism.css">';
                    break;
                case 'select2':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/select2.css">';
                    break;
                case 'select2':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/select2.css">';
                    break;
                case 'date-picker':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/date-picker.css">';
                    break;
                case 'datatable':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/datatables.css">';
                    break;
                case 'summernote':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/summernote.css">';
                    break;
                case 'toastr':
                    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
                    break;
                case 'photoswipe':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/photoswipe.css">';
                    break;
                case 'daterange-picker':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/daterange-picker.css">';
                    break;
                case 'fancybox':
                    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>';
                    break;
                default:
                    break;
            }
        }
    }
}

function gerar_rodape() {
    ?>
    <!-- latest jquery-->
    <script src="<?php echo WEBURL ?>assets/js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="<?php echo WEBURL ?>assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="<?php echo WEBURL ?>assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?php echo WEBURL ?>assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->
    <script src="<?php echo WEBURL ?>assets/js/scrollbar/simplebar.js"></script>
    <script src="<?php echo WEBURL ?>assets/js/scrollbar/custom.js"></script>
    <!-- Sidebar jquery-->
    <script src="<?php echo WEBURL ?>assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="<?php echo WEBURL ?>assets/js/sidebar-menu.js"></script>
    <script src="<?php echo WEBURL ?>assets/js/tooltip-init.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?php echo WEBURL ?>assets/js/script.js"></script>
    <!-- login js-->
    <?php
}

function gerar_js($plugins = array()) {
    if (!empty($plugins)) {
        foreach ($plugins as $LOAD_PLUGINS) {
            switch ($LOAD_PLUGINS) {
                case 'sweetalert':
                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
                    break;
                case 'form-submit':
                    echo '<script src="' . WEBURL . 'assets/js/form-validation-custom.js"></script>';
                    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/includes/js/form-submit.php';
                    break;
                case 'prism':
                    echo '<link rel="stylesheet" type="text/css" href="' . WEBURL . 'assets/css/vendors/prism.css">';
                    break;
                case 'datatable':
                    echo '<script src="' . WEBURL . 'assets/js/datatable/datatables/jquery.dataTables.min.js"></script>';
                    echo '<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>';
                    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>';
                    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>';
                    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>';
                    echo '<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>';
                    echo '<script src="https://cdn.datatables.net/plug-ins/1.10.21/filtering/type-based/accent-neutralise.js"></script>';
                    break;
                case 'select2':
                    echo '<script src="' . WEBURL . 'assets/js/select2/select2.full.min.js"></script>';
                    break;
                case 'date-picker':
                    echo '<script src="' . WEBURL . 'assets/js/datepicker/date-picker/datepicker.js"></script>';
                    echo '<script src="' . WEBURL . 'assets/js/datepicker/date-picker/datepicker.en.js"></script>';
                    break;
                case 'summernote':
                    echo '<script src="' . WEBURL . 'assets/js/editor/summernote/summernote.js?v=1.1"></script>';
                    break;
                case 'management':
                    echo '<script src="' . WEBURL . 'code/js/management.js?v=1.3"></script>';
                    break;
                case 'toastr':
                    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
                    break;
                case 'mask-money':
                    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha256-U0YLVHo5+B3q9VEC4BJqRngDIRFCjrhAIZooLdqVOcs=" crossorigin="anonymous"></script>';
                    break;
                case 'mask':
                    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous"></script>';
                    break;
                case 'photoswipe':
                    echo '<script src="' . WEBURL . 'assets/js/photoswipe/photoswipe.min.js"></script>';
                    echo '<script src="' . WEBURL . 'assets/js/photoswipe/photoswipe-ui-default.min.js"></script>';
                    echo '<script src="' . WEBURL . 'assets/js/photoswipe/photoswipe.js"></script>';
                    break;
                case 'touchspin':
                    echo '<script src="' . WEBURL . 'assets/js/touchspin/touchspin.js"></script>';
                    echo '<script src="' . WEBURL . 'assets/js/touchspin/input-groups.min.js"></script>';
                    break;
                case 'daterange-picker':
                    echo '<script src="' . WEBURL . 'assets/js/datepicker/daterange-picker/moment.min.js"></script>';
                    echo '<script src="' . WEBURL . 'assets/js/datepicker/daterange-picker/daterangepicker.js"></script>';
                    echo '<script src="' . WEBURL . 'assets/js/datepicker/daterange-picker/daterange-picker.custom.js"></script>';
                    break;
                case 'jspdf':
                    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script> ';
                    echo '<script src="https://cdn.jsdelivr.net/npm/canvas2image@1.0.5/canvas2image.min.js"></script>';
                    break;
                case 'morris-chart':
                    echo '<script src="' . WEBURL . 'assets/js/chart/morris-chart/raphael.js"></script>';
                    echo '<script src="' . WEBURL . 'assets/js/chart/morris-chart/morris.js"></script>';
                    echo '<script src="' . WEBURL . 'assets/js/chart/morris-chart/prettify.min.js"></script>';
                    break;
                case 'fancybox':
                    echo '<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>';
                    break;
                case 'exibition':
                    echo '<script src="' . WEBURL . 'php/modulos/usuarios/administrador/code/js/exibition.js"></script>';
                    break;
                case 'mask':
                    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>';
                    break;
                default:
                    break;
            }
        }
    }
}

function gerar_hash() {
    return md5(sha1(sha1(uniqid() . uniqid() . date('YmdHisu') . uniqid())));
}

function edicao_terceiro(){
    echo '<script src="' . WEBURL . 'php/modulos/usuarios/administrador/code/js/hide_funcionario"></script>';
}

function edicao_funcionario(){
    echo '<script src="' . WEBURL . 'php/modulos/usuarios/administrador/code/js/hide_terceiro"></script>';
}


function sessao(){
    if(!isset($_SESSION['usuario']))
{
    session_start();
}

if(isset($_SESSION['usuario']) && is_array($_SESSION['usuario']))
{
    $hash = $_SESSION['usuario']['SESS_USER_HASH'];
    $email = $_SESSION['usuario']['SESS_USER_EMAIL'];
    $hierarquia = $_SESSION['usuario']['SESS_USER_HIERARQUIA'];
} else {
    header('Location: http://localhost/');
}
}