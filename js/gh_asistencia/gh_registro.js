$(document).ready(function () {
    if($('#msgError').html().length > 0 || $('#msgSuccess').html().length > 0) {
        // Para que funcione correctamente debe llamarse una funcion, no directamente
        setTimeout(recargar, 2000);
    }
    
    $('#codigoBarras').keypress(function(event) {
        if ((event.which == 8) || (event.which == 0) || (event.which == 45))
            return true;
        if ((event.which >= 48) && (event.which <= 57))
            return true;
        else if (event.which == 13) {
            if ($('#codigoBarras').val().length == 7 || $('#codigoBarras').val().length == 8 || $('#codigoBarras').val().length == 12 || $('#codigoBarras').val().length == 13) {
                $('#divMsgAlert').hide();
                $('#frmAsistencia').submit();
            } else {
                $('#msgError').html('El codigo debe ser de 8 o 13 digitos.');
                $('#divMsgAlert').show();
            }
        } else {
            //$('#codigoBarras').val('');
        }
        return false;
    });
    
    $('#btnRegistrar').click(function () {
        if($('#codigoBarras').val().length == 7 || $('#codigoBarras').val().length == 8 || $('#codigoBarras').val().length == 12 || $('#codigoBarras').val().length == 13) {
            $('#divMsgAlert').hide();
            $('#frmAsistencia').submit();
        } else {
            $('#msgError').html('El codigo debe ser de 8 o 13 digitos.');
            $('#divMsgAlert').show();
        }
        return false;
    });
    
    $('#btnRefrescar').click(function () {
        //location.reload();
        window.location.href = base_url + 'gh_asistencia';
    });
});

function recargar() {
    var pagina = base_url + 'gh_asistencia';
    window.location.href = pagina;
}