<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    form.classList.remove('not-valid-form');
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Campos obrigatórios não preenchidos!'
                        });
                        form.classList.add('not-valid-form');
                    } else {
                        $('form').removeClass('.was-validated');
                        event.preventDefault();
                        event.stopPropagation();
                        var btn = $('#' + form.attributes[0].value).find('button[type="submit"]');
                        var btn_text = btn.text();
                        var loader = '<div class="loader-box"><div class="loader-15"></div></div>';
                        btn.html(loader);
                        gerar_toastr();
                        $.ajax({
                            url: $('#' + form.attributes[0].value).attr('action'),
                            type: 'POST',
                            dataType: "JSON",
                            data: new FormData($('#' + form.attributes[0].value)[0]),
                            processData: false,
                            contentType: false,
                            success: function (data, status) {
                                if (data.status === 'OK') {
                                    toastr.clear();
                                    switch (data.type) {
                                        case 'redirect_dashboard':
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Sucesso!',
                                                text: data.message
                                            }).then(function () {
                                                window.location.href = '/dashboard';
                                            });
                                            break;
                                        case 'redirect':
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Sucesso!',
                                                text: data.message
                                            }).then(function () {
                                                window.location.href = data.url;
                                            });
                                            break;
                                        default:
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Sucesso!',
                                                text: data.message
                                            }).then(function () {
                                                window.location.reload();
                                            });
                                            break;
                                    }
                                } else {
                                    toastr.clear();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: data.message
                                    });
                                    btn.html(btn_text);
                                }
                            }
                        });
                        return false;
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>