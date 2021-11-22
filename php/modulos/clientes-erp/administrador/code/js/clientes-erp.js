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

 $(document).on('click', '.add_cnae', function(){ 
    $( "#cnae_secundarios" ).clone().appendTo( ".cnae-sec" );
    

 });