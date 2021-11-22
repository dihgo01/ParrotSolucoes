$('body').on('click', '[data-delete-prod]', function () {
    var key = $(this).attr('data-delete-prod');
    var table = $(this).attr('data-delete-table-prod');
    var parameter = $(this).attr('data-delete-param');
    var message = $(this).attr('data-delete-msg');
    Swal.fire({
        title: 'Confirmação',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d10000',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, quero excluir!',
        cancelButtonText: 'Voltar'
    }).then((result) => {
        if (result.value) {
            gerar_toastr();
            $.ajax({
                url: '/php/modulos/produtos/administrador/code/ajax-produtos.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action_type: 'excluir_item',
                    key: key,
                    table: table,
                    parameter: parameter
                },
                success: function (data) {
                    toastr.clear();
                    if (data.status === 'OK') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: data.message
                        }).then(function () {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Ooops!",
                            text: data.message,
                            icon: "error",
                            cancelButtonText: "Entendi",
                        });
                    }
                }
            });
        }
    });
});
