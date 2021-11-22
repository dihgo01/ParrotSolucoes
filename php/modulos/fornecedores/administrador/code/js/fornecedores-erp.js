$('#submit-forms').click(function(){
    const porte_empresa = $('select[name=porte]').val();
    const  juridica = $('select[name=nat_juridica]').val();
    const estado = $('select[name=estado]').val();
    const q_pais = $('select[name=pais]').val();
    const q_cidade = $('select[name=cidade]').val();

    $.ajax({
        url: 'php/modulos/fornecedores/administrador/code/action/ajax-fornecedores.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            action_type: 'gestao_de_fornecedores',
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
        url: '/php/modulos/fornecedores/administrador/code/ajax-fornecedores.php',
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

 /**
  * 
  * 
  * 
  *    $busca_cidade = $classesWeb->busca_cidade_por_estado($_POST['estado']);
     //var_dump($busca_estados);
     if (isset($busca_cidade) && !empty($busca_cidade)) {
     echo '<option value=""><-- Selecione uma Cidade --></option>';
    foreach ($busca_cidade as $key => $value) {
    echo '<option data-cidade="' . $value->uf . '" value="' . $value->nome . '">' . $value->nome . '</option>';
       } ?>
      <?php } else { ?>
     <option selected="">Nada encontrado</option>
       <?php } ?>
       <?php } ?>
  */


$('#cnaes').click(function(){
    $('#exampleModalCenterCNAE').modal('toggle');
})

$('#cnaes_close').click(function(){
    $('#exampleModalCenterCNAE').modal('hide');
})

$('#emails').click(function(){
    $('#exampleModalCenterEmails').modal('toggle');
})

$('#emails_close').click(function(){
    $('#exampleModalCenterEmails').modal('hide');
})

$('#telefones').click(function(){
    $('#exampleModalCenterTelefone').modal('toggle');
})

$('#telefones_close').click(function(){
    $('#exampleModalCenterTelefone').modal('hide');
})