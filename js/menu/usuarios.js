$(function () {
    /**
     * Valores iniciales de los campos de Descuento.
     * @author Angela Liliana Rodriguez Mahecha
     * @since  Julio 07 / 2015
     */
    $('#txtCedula').bloquearTexto().maxlength(12);
    $('#txtCoddes').bloquearTexto().maxlength(12);
    $('#txtCuotas').bloquearTexto().maxlength(12);
    $('#txtValorCuota').bloquearTexto().maxlength(12);

    /**
     * Muestra el resultado de la cedula digitada.
     * @author Angela Liliana Rodriguez Mahecha
     * @since  Julio 09 / 2015
     */
    
    $('#txtCedula').keypress(function (event) {
        if (event.which == 13) {
            var valced = $('#txtCedula').val();
            var regreso = $('#regreso').val();
            if (valced > 0 || valced != '') {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'menu/buscafuncionario',
                    data: {'cedula': valced, 'regreso': regreso},
                    cache: false,
                    success: function (data) {
                        $('#nombres').html(data);
                        $('#infoPermisos').html('');
                    }
                });
            }
        }
    });
    
    $('#txtCedula').blur(function () {
        var valced = $('#txtCedula').val();
        var regreso = $('#regreso').val();
        if (valced > 0 || valced != '') {
            $.ajax ({
                type: 'POST',
                url: base_url + 'menu/buscafuncionario',
                data: {'cedula': valced, 'regreso': regreso},
                cache: false,
                success: function (data) {
                    $('#nombres').html(data);
                    $('#infoPermisos').html('');
                }
            });
        }
    });
});