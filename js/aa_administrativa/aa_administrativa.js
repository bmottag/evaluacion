$(function () {


    $("#formMatenimiento").validate({
        //Reglas de Validacion
        rules: {
            piso: {required: true},
            tipo: {required: true},
            descripcion: {required: true}
        },
        //Mensajes de error
        errorPlacement: function (error, element) {
            element.after(error);
            error.css('display', 'inline');
            error.css('margin-left', '10px');
            error.css('color', "#FF0000");

            //	$(element).focus();
        },
        messages: {
            piso: {
                required: "Seleccionar Piso."
            },
            tipo: {
                required: "Seleccionar Tipo de Mantenimiento."
            },
            descripcion: {
                required: "Ingresar la descripci\u00F3n del servicio."
            }
        },
        submitHandler: function (form) {
            return true;

        }
    });
    $("#btnSolicitudMantenimiento").click(function () {

        if ($("#formMatenimiento").valid() == true) {

            if (window.confirm('Haga clic en Aceptar para guardar'))
            {
                //Activa icono guardando
                $('#btnSolicitudMantenimiento').attr('disabled', '-1');
                $("#div_guardado").css("display", "none");
                $("#div_error").css("display", "none");
                $("#div_cargando").css("display", "inline");

                $.ajax({
                    type: "POST",
                    url: base_url + "aa_administrativa/guardaDatosFormulario",
                    data: $("#formMatenimiento").serialize(),
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                    cache: false,
                    success: function (data) {
                        //data=utf8_decode(data);
                        //if(data ==="-ok-")
                        //alert(data.length);
                        if (resultadoValido(data)) {

                            //Oculta icono guardando
                            $("#div_cargando").css("display", "none");
                            $("#div_guardado").css("display", "inline");

                            bootbox.alert('Solicitud guardada correctamente.');
                            location.reload();
                            $('#btnSolicitudMantenimiento').removeAttr('disabled');

                        } else {
                             bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                            $("#div_cargando").css("display", "none");
                            $("#div_error").css("display", "inline");
                            $('#btnSolicitudMantenimiento').removeAttr('disabled');
                        }
                    },
                    error: function (result) {
                         bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                        $("#div_cargando").css("display", "none");
                        $("#div_error").css("display", "inline");
                        $('#btnSolicitudMantenimiento').removeAttr('disabled');
                    }
                });
            }
        }//if
    });
});//EOC

function resultadoValido(data) {
    if ((!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)))
        return true;
    else
        return false;
}