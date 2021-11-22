<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once 'code/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?php
        gerar_cabecalho();
        gerar_css(array(
            'toastr',
            'management',
        ));
        ?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7"><img class="bg-img-cover bg-center" src="<?php echo WEBURL ?>assets/images/login/2.jpg" alt="looginpage"></div>
                <div class="col-xl-5 p-0">
                    <div class="login-card">
                        <div>
                            <div>
                                <a class="logo text-start" href="<?php echo WEBURL ?>">
                                    <img class="img-fluid for-light" src="<?php echo WEBURL ?>assets/images/logo/login.png" alt="looginpage">
                                    <img class="img-fluid for-dark" src="<?php echo WEBURL ?>assets/images/logo/logo_dark.png" alt="looginpage">
                                </a>
                            </div>
                            <div class="login-main"> 
                                <form id="form-login" class="theme-form needs-validation" novalidate="" action="<?php echo WEBURL ?>code/ajax.php?action_type=login" method="POST">
                                    <h4>Entre na sua conta</h4>
                                    <p>Informe o e-mail e a senha de acesso para acessar a sua conta na platforma.</p>
                                    <div class="form-group">
                                        <label class="col-form-label">E-mail</label>
                                        <input class="form-control" type="text" name="email" placeholder="E-mail" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Senha</label>
                                        <input class="form-control" type="password" name="senha" placeholder="Senha" required>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button class="btn btn-primary btn-block mt-3" type="submit">Entrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- latest jquery-->
            <script src="<?php echo WEBURL ?>assets/js/jquery-3.5.1.min.js"></script>
            <!-- Bootstrap js-->
            <script src="<?php echo WEBURL ?>assets/js/bootstrap/bootstrap.bundle.min.js"></script>
            <!-- feather icon js-->
            <script src="<?php echo WEBURL ?>assets/js/icons/feather-icon/feather.min.js"></script>
            <script src="<?php echo WEBURL ?>assets/js/icons/feather-icon/feather-icon.js"></script>
            <!-- scrollbar js-->
            <!-- Sidebar jquery-->
            <script src="<?php echo WEBURL ?>assets/js/config.js"></script>
            <!-- Plugins JS start-->
            <!-- Plugins JS Ends-->
            <!-- Theme js-->
            <script src="<?php echo WEBURL ?>assets/js/script.js"></script>
            <!-- login js-->
            <!-- Plugin used-->
            <?php
            gerar_rodape();
            gerar_js(array(
                'toastr',
                'sweetalert',
                'form-submit',
                'management'
            ));
            ?>  
        </div>
    </body>
</html>