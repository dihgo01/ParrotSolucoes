$(document).ready(function () {
    $('body').on('change', '.get-accounts', function () {
        gerar_toastr();
        var key = $(this).find('option:selected').val();
        $.ajax({
            url: '/php/modulos/estoque/administrador/code/ajax-estoque.php',
            type: 'POST',
            data: {
                action_type: 'buscar_contas',
                key: key
            },
            success: function (data) {
                $('.set-accounts').html(data);
                toastr.clear();
            }
        });
    });
    $('body').on('change', '.get-favored', function () {
        gerar_toastr();
        var key = $(this).find('option:selected').val();
        $.ajax({
            url: '/php/modulos/financeiro/administrador/code/ajax-financeiro.php',
            type: 'POST',
            data: {
                action_type: 'buscar_favorecidos',
                key: key
            },
            success: function (data) {
                $('.set-favored').html(data);
                toastr.clear();
            }
        });
    });

    $('select[name="recorrencia"]').change(function () {
        if ($(this).find('option:selected').val() === 'Sim') {
            $('input[name="recorrenciaDataFinal"]').val('').prop('required', true);
        } else {
            $('input[name="recorrenciaDataFinal"]').val('').prop('required', false);
        }
    });

    $('body').on('click', '#btnFiltroMovimentacoesFinanceiras', function () {
        gerar_toastr();
        $.ajax({
            type: 'POST',
            url: '/php/modulos/financeiro/administrador/code/ajax-financeiro.php',
            data: {
                action_type: 'filtro_movimentacoes',
                data: $('input[name="filtro-data"]').val(),
                tipo: $('select[name="filtro-tipo"]').val(),
                centro_custo: $('select[name="filtro-centro-custo"]').val(),
                conta: $('select[name="filtro-conta"]').val(),
                status: $('select[name="filtro-status"]').val()
            },
            success: function (data) {
                $('#movimentacoesTable').DataTable().destroy();
                $('#movimentacoesTable tbody').html('');
                $('#movimentacoesTable tbody').html(data);
                $('#movimentacoesTable').DataTable({
                    "bSort": false,
                    "displayLength": 20,
                    "lengthMenu": [[20, 50, 100], [20, 50, 100]],
                    "responsive": true,
                    language: {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                    },
                    "initComplete": function (settings, json) {

                    }
                });
                toastr.clear();
            }
        });
    });
});

$('#submit-forms-clientes').click(function(){
    const porte_empresa = $('select[name=porte]').val();
    const  juridica = $('select[name=nat_juridica]').val();
    const estado = $('select[name=estado]').val();
    const q_pais = $('select[name=pais]').val();
    const q_cidade = $('select[name=cidade]').val();

    $.ajax({
        url: 'php/modulos/clientes/administrador/code/action/ajax-clientes.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            action_type: 'gestao_clientes',
            porte: porte_empresa,
            nat_juridica: juridica,
            estado: estado,
            cidade : q_cidade,
            pais: q_pais
        },success: function (data) {
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
});
$(document).on('change', '#estado', function(){  

    let Estado = $('#estado option:selected').attr('data-estado');
   
    $.ajax({
        url: '/php/modulos/clientes/administrador/code/ajax-clientes.php',
        type: 'POST',
        data: {
            action_type: 'pegando_cidades',
            estado: Estado,
            
        },success(response){   
             $("#cidade").html(response);
             console.log(response);

        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr, ajaxOptions, thrownError);
            $("#msgClima").html('<div class="alert alert-danger fade in"><button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-times"></i><strong>ATENÇÃO!</strong> Ocorreu um erro ao tentar enviar a pergunta. Contate o suporte técnico.</div>');
        }
    });
 });