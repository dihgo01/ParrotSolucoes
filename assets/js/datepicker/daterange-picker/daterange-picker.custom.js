
//DateRange Picker
(function ($) {
    "use strict";
    $(function () {
        $('input[name="daterange"]').daterangepicker();
    });
//Date and Time
    $(function () {
        $('input[name="daterange2"]').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            }
        });
    });
// Single Date Picker
    $(function () {
        $('input[name="birthdate"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true
        },
                function (start, end, label) {
                    var years = moment().diff(start, 'years');
                    alert("You are " + years + " years old.");
                });
    });


//Predefined Ranges
    $(function () {
        var start = moment().subtract(8, 'days');
        var end = moment().subtract(1, 'days');
        function cb(start, end) {
            $('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            locale: {
                format: "DD/MM/YYYY",
                cancelLabel: 'Limpar',
                applyLabel: 'Aplicar',
                separator: ' até ',
                fromLabel: 'De',
                toLabel: 'Até',
                customRangeLabel: 'Data Personalizada',
                "daysOfWeek": [
                    "D",
                    "S",
                    "T",
                    "Q",
                    "Q",
                    "S",
                    "S"
                ],
                "monthNames": [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro"
                ]
            },
            ranges:
                    {
                        'Hoje': [moment(), moment()],
                        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
                        'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
                        'Este mês': [moment().startOf('month'), moment().endOf('month')],
                        'Mês passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
        }, cb);

        cb(start, end);

    });
//Input Initially Empty
    $(function () {

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Limpar'
            }
        });
        $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });
        $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
}
)(jQuery);