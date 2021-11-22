var current_url = window.location.href;
var split_url = current_url.split('/');

console.log(split_url);
$(document).ready(function () {
    if ($('.field-get-date').length > 0) {
        $('.field-get-date').datepicker({
            language: 'en',
            autoHide: true
        });
    }

    if ($('.field-get-month').length > 0) {
        var date = new Date();
        $(".field-get-month").datepicker({
            language: 'en',
            autoHide: true,
            dateFormat: 'MM de yyyy',
            changeMonth: true,
            changeYear: true,
            minDate: new Date(date.setMonth(date.getMonth() + 1))
        });
    }

    $('.field-get-date, .field-get-month').on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });

    if ($('.field-get-date-month').length > 0) {
        $('.field-get-date-month').datetimepicker({
            language: 'en',
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
    }

    $('body').on('click', '.dropdown-toggle', function () {
        $(this).next().toggle();
    });

    if ($('.field-currency').length > 0) {
        $('.field-currency').maskMoney({
            prefix: 'R$ ',
            thousands: '.',
            decimal: ',',
            precision: 2
        });
    }

    if ($('.field-percent-decimal').length > 0) {
        $('.field-percent-decimal').maskMoney({
            prefix: '',
            suffix: '%',
            thousands: '',
            decimal: ',',
            precision: 2
        });
    }

    if ($('.stock-min, .number').length > 0) {
        $('.stock-min, .number').maskMoney({
            prefix: '',
            thousands: '',
            decimal: ',',
            precision: 0
        });
    }

    if ($('.decimal').length > 0) {
        $('.decimal').maskMoney({
            prefix: '',
            thousands: '',
            decimal: ',',
            precision: 3
        });
    }

    if ($('.field-phone').length > 0) {
        $('.field-phone').mask('(99) 99999-9999');
    }

    if ($('.field-cnpj').length > 0) {
        $('.field-cnpj').mask('99.999.999/9999-99');
    }

    if ($('.field-estadual').length > 0) {
        $('.field-estadual').mask('99.999.9999-9');
    }

    if ($('.field-rg').length > 0) {
        $('.field-rg').mask('99.999.999/99');
    }

    if ($('.field-cpf').length > 0) {
        $('.field-cpf').mask('999.999.999-99');
    }

    if ($('.field-cbo').length > 0) {
        $('.field-cbo').mask('9999-99');
    }

    if ($('.field-date').length > 0) {
        $('.field-date').mask('99/99/9999');
    }

    if ($('.field-cep').length > 0) {
        $('.field-cep').mask('99999-999');
    }

    $('.search-cep').blur(function () {
        var cep = $(this).val();
        cep = cep.replace('-', '');
        if (parseInt(cep.length) === 8) {
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
                if (data.hasOwnProperty('erro') && data.erro === true) {
                    Swal.fire(
                            'Ooops!',
                            'Por favor, digite um CEP válido.',
                            'error'
                            );
                } else {
                    if (data.hasOwnProperty('logradouro') && data.logradouro !== '') {
                        $('input[name="logradouro"]').val(data.logradouro);
                    }
                    if (data.hasOwnProperty('bairro') && data.bairro !== '') {
                        $('input[name="bairro"]').val(data.bairro);
                    }
                    if (data.hasOwnProperty('uf') && data.uf !== '') {
                        $('select option[data-estado="' + data.uf + '"]').prop("selected", true).trigger('change');
                    }
                    if (data.hasOwnProperty('localidade') && data.localidade !== '') {
                        setTimeout(function () {
                            $('select option[data-cidade="' + data.localidade + '"]').prop("selected", true);
                        }, 2000);
                    }
                }
            });
        }
    });

    if ($('.general-select2').length > 0) {
        $('.general-select2').each(function () {
            $(this).select2({
                placeholder: "Selecione",
                "language": {
                    "noResults": function () {
                        return "Nada encontrado.";
                    }
                }
            });
        });
    }

    if ($('.general-select2-multiple').length > 0) {
        $('.general-select2-multiple').each(function () {
            $(this).select2({
                placeholder: "Selecione",
                multiple: true,
                "language": {
                    "noResults": function () {
                        return "Nada encontrado.";
                    }
                }
            });
        });
    }

    if ($('.start-datatable').length > 0) {
        $('.start-datatable').each(function () {
            var element = $(this);
            element.DataTable({
                "bSort": false,
                "displayLength": 20,
                "lengthMenu": [[20, 50, 100], [20, 50, 100]],
                "responsive": true,
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "initComplete": function (settings, json) {
                    setTimeout(function () {
                        $('.loader-datatable').hide();
                        element.show();
                        $('.start-datatable-elemet').show();
                    }, 1500);
                }
            });
        });
    }

    if ($('.summernote').length > 0) {
        var id_text = 1;
        $('.summernote').each(function () {
            $(this).summernote({
                height: 300,
                tabsize: 2,
                placeholder: 'Digite o texto aqui',
                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen']]
                ],
                lang: 'pt-BR'
            });
            $(this).parent().find('.note-codable').attr('name', 'texto_' + id_text);
            if (split_url[3] === 'gerenciamento' && split_url[4] === 'help-desk' && split_url[5] === 'conteudos' && split_url[6] === 'edicao') {
                $(this).parent().find('.note-codable').val($(this).summernote('code'));
            }
            id_text += 1;
        });
    }

    $(".summernote").on("summernote.change", function (e) {
        $(this).parent().find('textarea').val($(this).summernote('code'));
    });

    $('body').on('click', '[data-delete-item]', function () {
        var key = $(this).attr('data-delete-item');
        var table = $(this).attr('data-delete-table');
        var parameter = $(this).attr('data-delete-parameter');
        var message = $(this).attr('data-delete-message');
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
                    url: '/code/ajax.php',
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

    $('body').on('click', '[data-mudar-status]', function () {
        var key = $(this).attr('data-mudar-status');
        var table = $(this).attr('data-mudar-table');
        var parameter = $(this).attr('data-mudar-parameter');
        var new_value = $(this).attr('data-mudar-value');
        var message = $(this).attr('data-mudar-message');
        Swal.fire({
            title: 'Confirmação',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, quero alterar!',
            cancelButtonText: 'Voltar'
        }).then((result) => {
            if (result.value) {
                gerar_toastr();
                $.ajax({
                    url: '/code/ajax.php',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        action_type: 'mudar_status_item',
                        key: key,
                        table: table,
                        parameter: parameter,
                        new_value: new_value
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
                                type: "error",
                                cancelButtonText: "Entendi",
                            });
                        }
                    }
                });
            }
        });
    });

    $('body').on('click', '#confirmar', function () {
        var key = $(this).attr('data-mudar-status');
        var table = $(this).attr('data-mudar-table');
        var parameter = $(this).attr('data-mudar-parameter');
        var new_value = $(this).attr('data-mudar-value');
        var message = $(this).attr('data-mudar-message');
        Swal.fire({
            title: 'Confirmação',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, quero alterar!',
            cancelButtonText: 'Voltar'
        }).then((result) => {
            if (result.value) {
                gerar_toastr();
                $.ajax({
                    url: '/code/ajax.php',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        action_type: 'mudar_status_item',
                        key: key,
                        table: table,
                        parameter: parameter,
                        new_value: new_value
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
                                type: "error",
                                cancelButtonText: "Entendi",
                            });
                        }
                    }
                });
            }
        });
    });



    $('body').on('change', '.set-category', function () {
        var div = $(this).parent().parent();
        var key = $(this).find('option:selected').val();
        $.ajax({
            url: '/code/ajax.php',
            type: 'POST',
            data: {
                action_type: 'buscar_categorias_produtos',
                key: key
            },
            success: function (data) {
                div.find('.get-category').html(data);
                div.find('.get-category').trigger('change');
            }
        });
    });

    $('body').on('change', '.set-subcategory', function () {
        var div = $(this).parent().parent();
        var key = $(this).find('option:selected').val();
        $.ajax({
            url: '/code/ajax.php',
            type: 'POST',
            data: {
                action_type: 'buscar_subcategorias_produtos',
                key: key
            },
            success: function (data) {
                div.find('.get-subcategory').html(data);
            }
        });
    });

    $('body').on('change', '.set-city', function () {
        var div = $(this).parent().parent();
        var key = $(this).find('option:selected').attr('data-estado');
        $.ajax({
            url: '/code/ajax.php',
            type: 'POST',
            data: {
                action_type: 'buscar_cidades',
                key: key
            },
            success: function (data) {
                div.find('.get-city').html('');
                div.find('.get-city').html(data);
            }
        });
    });

    if ($('.datepicker-here').length > 0) {
        if (window.location.href.indexOf('edicao') > -1) {
            $('.datepicker-here').each(function () {
                var selected_date = $(this).next().val();
                $(this).val(selected_date);
            });
        }
    }

    if ($('.insertValueSelect').length > 0) {
        if (window.location.href.indexOf('edicao') > -1) {
            $('.insertValueSelect').each(function () {
                var selected_vale = $(this).val();
                $(this).prev().val(selected_vale);
            });
        }
    }
});

function gerar_toastr(toaster_titulo = 'AGUARDE', toaster_mensagem = 'Processando requisição', toaster_tipo = 'info') {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    switch (toaster_tipo) {
        case 'warning':
            toastr.warning(toaster_mensagem, toaster_titulo);
            break;
        case 'danger':
            toastr.danger(toaster_mensagem, toaster_titulo);
            break;
        case 'success':
            toastr.success(toaster_mensagem, toaster_titulo);
            break;
        case 'info':
            toastr.info(toaster_mensagem, toaster_titulo);
            break;
        default:
            toastr.warning(toaster_mensagem, toaster_titulo);
            break;
}

}
$('.search-cnpj').blur(function () {
    var cnpj = $(this).val();
    cnpj = cnpj.replace(/[^0-9]/g , '');
    //console.log(cnpj);
    if (parseInt(cnpj.length) === 14) {
        $.getJSON('https://api-publica.speedio.com.br/buscarcnpj?cnpj=' + cnpj , function (data) {
        
        if (data.error) {

                Swal.fire(
                        'Ooops!',
                        'Por favor, digite um CNPJ inválido.',
                        'error'
                        ); 
            } else {
                console.log(data)   
                if (data.hasOwnProperty('NOME FANTASIA') && data.NOMEFANTASIA !== '') {
                    $('input[name="razao_social"]').val(data.NOMEFANTASIA);
                }
                if (data.hasOwnProperty('RAZAO SOCIAL') && data.RAZAOSOCIAL!== '') {
                    $('input[name="nome_fantasia"]').val(data.RAZAOSOCIAL);
                }

            }
        });
    }
});


