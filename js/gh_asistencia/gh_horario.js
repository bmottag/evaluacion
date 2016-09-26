$(document).ready(function () {    
    var formatearFecha = function (fecha) {
        var temp = [];
        if (fecha.split('/')) {
            temp = fecha.split('/');
            return temp[2] + '-' + temp[1] + '-' + temp[0];
        } else if (fecha.split('-')) {
            temp = fecha.split('-');
            return temp[2] + '/' + temp[1] + '/' + temp[0];
        }
    };
    
    $.validator.addMethod('endDate', function(value, element, params) {
        var startDate = formatearFecha($('#' + params[0]).val());
        var endD = formatearFecha($('#' + params[1]).val());
        return Date.parse(startDate) <= Date.parse(endD);
    });
    
    $.validator.addMethod('endHour', function(value, element, params) {
        var startHour = $('#' + params[0]).val();
        var endH = $('#' + params[1]).val();
        var temp1 = startHour.split(':');
        var temp2 = endH.split(':');
        var startDate = new Date();
        var endDate = new Date();
        startDate.setHours(temp1[0], temp1[1]);
        endDate.setHours(temp2[0], temp2[1]);
        return Date.parse(startDate) <= Date.parse(endDate);
    });
    
    $('#txtFechaReso').datepicker({
        changeMonth: true,
        dateFormat: 'dd/mm/yy',
        minDate: '0',
        maxDate: '+1M',
        minDate:  new Date(2015, 0, 1),
        changeYear: true
    });
    
    var rangoFecha = $('#txtFechaInicial, #txtFechaFinal').datepicker({
        defaultDate: '+1d',
        changeMonth: true,
        dateFormat: 'dd/mm/yy',
        numberOfMonths: 1,
        onSelect: function (selectedDate) {
            var option = this.id == 'txtFechaInicial' ? 'minDate' : 'maxDate',
                    instance = $(this).data('datepicker');
            date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings);
            rangoFecha.not(this).datepicker('option', option, date);
        }
    });
    
    $('.timepicker-jq').timepicker(
	$.timepicker.regional['es']
    );
    
    $('#txtNumeroReso').bloquearTexto().maxlength(6);
    
    $('#btnGuardar').click(function () {
        var na = '';
        var cadena = $('#frmHorario').serializeArray();
        $.each(cadena, function (key, value) {
            na = value['name'].substring(3);
            if ($('#alert' + na).length) {
                $('#alert' + na).html('');
                $('#alert' + na).hide();
            }
        });
        $('#frmHorario').submit();
        return false;
    });
    
    $('#btnActualizar').click(function () {
        $('#frmHorario').submit();
        return false;
    });
    
    $('#btnRegresar').click(function () {
        //history.back(1);
        window.location.href = base_url + 'gh_asistencia/editarCodigoBarras/x';
    });
    
    $('#frmHorario').validate({
        rules: {
            txtNumeroReso: {required: true}, 
            txtFechaReso: {required: true},
            txtFechaInicial: {required: true, endDate:['txtFechaReso', 'txtFechaInicial']},
            txtFechaFinal: {required: true, endDate:['txtFechaInicial', 'txtFechaFinal']},
            txtEntradaL: {required: true},
            txtSalidaL: {required: true, endHour:['txtEntradaL', 'txtSalidaL']}
        },
        messages: {
            txtNumeroReso: {required: '* Debe digitar el número de la resolución.'},
            txtFechaReso: {required: '* Debe seleccionar la fecha de la resolución.'},
            txtFechaInicial: {required: '* Debe seleccionar la fecha que inicia el horario.', endDate: '* La fecha inicial debe ser mayor que la fecha de la resolución.'},
            txtFechaFinal: {required: '* Debe seleccionar la fecha que finaliza el horario.', endDate: '* La fecha final debe ser mayor que la fecha incial.'},
            txtEntradaL: {required: '* Debe seleccionar la hora de entrada para los lunes hábiles.'},
            txtSalidaL: {required: '* Debe seleccionar la hora de salida para los lunes hábiles.', endHour: '* La hora final debe ser mayor que la hora incial.'},
            txtEntradaM: {required: '* Debe seleccionar la hora de entrada para los martes hábiles.'},
            txtSalidaM: {required: '* Debe seleccionar la hora de salida para los martes hábiles.'},
            txtEntradaX: {required: '* Debe seleccionar la hora de entrada para los miércoles hábiles.'},
            txtSalidaX: {required: '* Debe seleccionar la hora de salida para los miércoles hábiles.'},
            txtEntradaJ: {required: '* Debe seleccionar la hora de entrada para los jueves hábiles.'},
            txtSalidaJ: {required: '* Debe seleccionar la hora de salida para los jueves hábiles.'},
            txtEntradaV: {required: '* Debe seleccionar la hora de entrada para los viernes hábiles.'},
            txtSalidaV: {required: '* Debe seleccionar la hora de salida para los viernes hábiles.'},
        },
        errorPlacement: function (error, element) {
            switch (element.attr('id')) {
                case 'txtNumeroReso':
                    $('#alertNumeroReso').html(error);
                    $('#alertNumeroReso').show();
                    break;
                case 'txtFechaReso':
                    $('#alertFechaReso').html(error);
                    $('#alertFechaReso').show();
                    break;
                case 'txtFechaInicial':
                    $('#alertFechaInicial').html(error);
                    $('#alertFechaInicial').show();
                    break;
                case 'txtFechaFinal':
                    $('#alertFechaFinal').html(error);
                    $('#alertFechaFinal').show();
                    break;
                case 'txtEntradaL':
                    $('#alertEntradaL').html(error);
                    $('#alertEntradaL').show();
                    break;
                case 'txtSalidaL':
                    $('#alertSalidaL').html(error);
                    $('#alertSalidaL').show();
                    break;
                case 'txtEntradaM':
                    $('#alertEntradaM').html(error);
                    $('#alertEntradaM').show();
                    break;
                case 'txtSalidaM':
                    $('#alertSalidaM').html(error);
                    $('#alertSalidaM').show();
                    break;
                case 'txtEntradaX':
                    $('#alertEntradaX').html(error);
                    $('#alertEntradaX').show();
                    break;
                case 'txtSalidaX':
                    $('#alertSalidaX').html(error);
                    $('#alertSalidaX').show();
                    break;
                case 'txtEntradaJ':
                    $('#alertEntradaJ').html(error);
                    $('#alertEntradaJ').show();
                    break;
                case 'txtSalidaJ':
                    $('#alertSalidaJ').html(error);
                    $('#alertSalidaJ').show();
                    break;
                case 'txtEntradaV':
                    $('#alertEntradaV').html(error);
                    $('#alertEntradaV').show();
                    break;
                case 'txtSalidaV':
                    $('#alertSalidaV').html(error);
                    $('#alertSalidaV').show();
                    break;
            }
        },
        submitHandler: function (form) {            
            form.submit();
        }
    });
});