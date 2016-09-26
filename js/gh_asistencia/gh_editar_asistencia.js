$(document).ready(function () {
    $('.timepicker-jq').timepicker(
	$.timepicker.regional['es']
    );
    
    $('#numeDocu').bloquearTexto();
    $('#numeDocu').keypress(function(event) {
        if (event.which == 13) {
            $('#divMsgAlert').hide();
            $('#frmAsistencia').submit();
        } else {
            //$('#codigoBarras').val('');
        }
    });
    
    $('#btnGuardar').click(function () {
        $('#divMsgAlert').hide();
        $('#frmAsistencia').submit();
        return false;
    });
});