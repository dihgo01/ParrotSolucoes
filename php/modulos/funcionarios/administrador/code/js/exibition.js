$(document).ready(function (){
    $('#usuario-externo').hide();
    $('#usuario-interno').hide();
    $('#card-usuario').hide();
})


$(document).ready(function (){
    $('#tipo').on('change', function(){
        if(selectValor === '#nulo'){
            $('#card-usuario').hide();
        } else {
            var selectValor = '#'+$(this).val();
            $('#usuarios').children('div').hide();
            $('#card-usuario').show();
            $('#usuarios').children(selectValor).show();
        }
    })
})