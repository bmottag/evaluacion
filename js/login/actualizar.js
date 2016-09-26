$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();

    $("#txtTelefono").bloquearTexto().maxlength(10);
    $("#txtExtension").bloquearTexto().maxlength(6);
    
    $("#formulario").validate({
        //Reglas de Validacion
        rules: {
            txtTelefono: {required: true},
            txtExtension: {required: true},
            cmbDespacho: {required: true}
        },
        //Mensajes de validacion
        messages: {
            txtTelefono: {required: "Campo requerido"},
            txtExtension: {required: "Campo requerido"},
            cmbDespacho: {required: "Seleccionar"}


        },
        //Mensajes de error
        errorPlacement: function (error, element) {
            element.after(error);
            error.css('display', 'inline');
            error.css('margin-left', '10px');
            error.css('color', "#FF0000");

            //	$(element).focus();
        },
        submitHandler: function (form) {
            return true;

        }
    });
    
    $("#btnGuardar").click(function () {
        if ($("#formulario").valid() == true) {
            var form = document.getElementById('formulario');
            form.submit();
        } else {
            bootbox.alert('Campos del formulario con errores. Revise y corrija.');
        }
    });

    $("#btnCrearCancelar, #btnCancelarActualizar").bind("click", function () {
        $(location).attr("href", base_url);
    });
});