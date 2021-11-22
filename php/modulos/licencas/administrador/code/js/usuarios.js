$(document).ready(function () {
    $('body').on('blur', '#nomeCompleto', function () {
        var login = [];
        var split_nome = $(this).val().trim().split(' ');
        login.push(split_nome[0].toUpperCase());
        split_nome.reverse();
        login.push(split_nome[0].toUpperCase());
        $('#login').val(login.join('.'));
    });
});

