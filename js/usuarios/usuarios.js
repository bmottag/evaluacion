$(function () {
    //Si el navegador es Internet Explorer, se redirecciona al módulo de Internet Explorer
    redirectBrowser();

    $("#txtTelefono").bloquearTexto().maxlength(10);
    $("#txtExtension").bloquearTexto().maxlength(6);

    $("#formGeneral").validate({
        //Reglas de Validacion
        rules: {
            cmbDespacho: {required: true},
            txtTelefono: {required: true},
            txtExtension: {required: true}
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
    $("#btnGeneral").click(function () {

        if ($("#formGeneral").valid() == true) {

            bootbox.confirm("Confirmar si desea guardar", function (result) {
                if (result) {
                    //Activa icono guardando
                    $('#btnGeneral').attr('disabled', '-1');
                    $("#div_guardado").css("display", "none");
                    $("#div_error").css("display", "none");
                    $("#div_cargando").css("display", "inline");

                    $.ajax({
                        type: "POST",
                        url: base_url + "usuarios/guardaDatos",
                        data: $("#formGeneral").serialize(),
                        dataType: "html",
                        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                        cache: false,
                        success: function (data) {
                            //data=utf8_decode(data);
                            //if(data ==="-ok-")
                            //alert(data.length);
                            if (resultadoValido(data))
                            {
                                $("#div_cargando").css("display", "none");
                                bootbox.alert("Se guardo la informaci\u00F3n correctamente.", function () {
                                    $("#div_guardado").css("display", "inline");
                                    location.reload();
                                    $('#btnGeneral').removeAttr('disabled');
                                });
                            } else
                            {
                                bootbox.alert("Error al guardar. Intente nuevamente o actualice la p\u00e1gina.", function () {
                                    $("#div_cargando").css("display", "none");
                                    $("#div_error").css("display", "inline");
                                    $('#btnGeneral').removeAttr('disabled');
                                });
                            }
                        },
                        error: function (result) {
                            bootbox.alert("Error al guardar. Intente nuevamente o actualice la p\u00e1gina.", function () {
                                $("#div_cargando").css("display", "none");
                                $("#div_error").css("display", "inline");
                                $('#btnGeneral').removeAttr('disabled');
                            });
                        }


                    });
                }
            });

        } else {
            bootbox.alert('Campos del formulario con errores. Revise y corrija.');
        }
    });
});//EOC

function resultadoValido(data) {
    if ((!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)))
        return true;
    else
        return false;
}