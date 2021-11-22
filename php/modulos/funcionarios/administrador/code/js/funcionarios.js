/*$('.search-cpf').blur(function () {
    alert();
    
    $.ajax({
        url: 'php/modulos/funcionarios/administrador/code/ajax-funcionarios.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            action_type: 'selecionar_funcionarios'
        },
        success: function (data){
            toastr.clear();
            if (data.hasOwnProperty('rg') && data.rg !== '') {
                $('input[name="rg"]').val(data.rg);
            }
             else {
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


$('.search-cpf').blur(function(){
    alert();
    const rg = $('select[name=rg]').val();
    const  nome_completo = $('select[name=nome_completo]').val();
    const nome_tratativa = $('select[name=nome_tratativa]').val();
    const email = $('select[name=email]').val();
    const senha = $('select[name=senha]').val();

    $.ajax({
        url: 'php/modulos/fornecedores/administrador/code/action/ajax-fornecedores.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            action_type: 'selecionar_funcionarios',
            rg: rg,
            nome_completo: nome_completo,
            nome_tratativa: nome_tratativa,
            email : email,
            senha: senha
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
}); */

$(document).on('change', '#estado', function(){  

    let Estado = $('#estado option:selected').attr('data-estado');
   
    $.ajax({
        url: '/php/modulos/funcionarios/administrador/code/ajax-funcionarios.php',
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