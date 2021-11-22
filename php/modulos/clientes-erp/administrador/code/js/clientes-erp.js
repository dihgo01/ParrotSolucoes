$(document).on('change', '#estado', function(){  
    
    let estado = $('#estado option:selected').attr('data-est');
   
    $.ajax({
        url: '/php/modulos/clientes-erp/administrador/code/ajax-clientes-erp.php',
        type: 'POST',
        data: {
            action_type: 'pegando_cidades',
            estado: estado,
            
        }, success(response){   
            $("#cidade").html(response);
           

       },
       error: function(xhr, ajaxOptions, thrownError) {
           console.log(xhr, ajaxOptions, thrownError);
           $("#msgClima").html('<div class="alert alert-danger fade in"><button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-times"></i><strong>ATENÇÃO!</strong> Ocorreu um erro ao tentar enviar a pergunta. Contate o suporte técnico.</div>');
       }
    });
 });

 $(document).on('click', '#emails', function(){ 
    $( "#email" ).clone().appendTo( ".form-email" ); 

 });

 $(document).on('click', '#dados-pessoa', function(){ 
    $( "#form-pessoa" ).clone().appendTo( "#form-dados-pessoa" ); 

 });

 $('#cnaes_secundarios').click(function(){
    $('#exampleModalCenterCNAE').modal('toggle');
})

$('.cnaes_close').click(function(){
    $('#exampleModalCenterCNAE').modal('hide');
})

$('#emails').click(function(){
    $('#exampleModalCenterEmails').modal('toggle');
})

$('.emails_close').click(function(){
    $('#exampleModalCenterEmails').modal('hide');
})

$('#telefones').click(function(){
    $('#exampleModalCenterTelefone').modal('toggle');
})

$('.telefones_close').click(function(){
    $('#exampleModalCenterTelefone').modal('hide');
})