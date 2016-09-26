function copiar_valor(hora, minutos, completo)
{
    var hora = document.getElementById(hora);
    var minutos = document.getElementById(minutos);
    var pegar = document.getElementById(completo);
    pegar.value = hora.value + ':' + minutos.value;
}

$(function () {
    $("#formSala").validate({
        //Reglas de Validacion
        rules: {
            NroPersonas: {required: true},
            hora1: {required: true},
            hora2: {required: true},
            titulo: {required: true},
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
            NroPersonas: {required: "Indicar el No. de personas."},
            hora1: {required: "Indicar la hora inicio del evento."},
            hora2: {required: "Indicar la hora final del evento."},
            titulo: {required: "Indicar T&iacute;tulo del evento."},
            descripcion: {required: "Indicar Descripci&oacute;n del evento."}
        },
        submitHandler: function (form) {
            return true;

        }
    });
    $("#btnSolicitud").click(function () {

        if ($("#formSala").valid() == true) {

            if (window.confirm('Haga clic en Aceptar para guardar'))
            {
                //Activa icono guardando
                $('#btnSolicitud').attr('disabled', '-1');
                $("#div_guardado").css("display", "none");
                $("#div_error").css("display", "none");
                $("#div_cargando").css("display", "inline");

                $.ajax({
                    type: "POST",
                    url: base_url + "gh_salas/guardaDatosFormulario",
                    data: $("#formSala").serialize(),
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                    cache: false,
                    success: function (data) {
                        if (resultadoValido(data))
                        {
                            //Oculta icono guardando
                            $("#div_cargando").css("display", "none");
                            $("#div_guardado").css("display", "inline");

                             bootbox.alert('Solicitud guardada correctamente.');
                            location.reload();

                            $('#btnSolicitud').removeAttr('disabled');

                        } else
                        {
                             bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                            $("#div_cargando").css("display", "none");
                            $("#div_error").css("display", "inline");
                            $('#btnSolicitud').removeAttr('disabled');
                        }
                    },
                    error: function (result) {
                         bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                        $("#div_cargando").css("display", "none");
                        $("#div_error").css("display", "inline");
                        $('#btnSolicitud').removeAttr('disabled');
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