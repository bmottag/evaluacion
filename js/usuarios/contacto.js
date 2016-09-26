$(function () {


    $("#txtCelular").bloquearTexto().maxlength(10);


    $("#formContacto").validate({
        //Reglas de Validacion
        rules: {
            txtNombres: {required: true, maxlength: 100},
            txtParentesco: {required: true, maxlength: 20},
            txtCelular: {required: true}
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
    $("#btnContacto").click(function () {

        if ($("#formContacto").valid() == true) {

                    bootbox.confirm("Confirmar si desea guardar", function(result){  
                        if (result) { 
                            //Activa icono guardando
                            $('#btnContacto').attr('disabled', '-1');
                            $("#div_guardado").css("display", "none");
                            $("#div_error").css("display", "none");
                            $("#div_cargando").css("display", "inline");

                            $.ajax({
                                type: "POST",
                                url: base_url + "usuarios/guardaContacto",
                                data: $("#formContacto").serialize(),
                                dataType: "html",
                                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                                cache: false,
                                success: function (data) {
                                    //data=utf8_decode(data);
                                    //if(data ==="-ok-")
                                    //bootbox.alert(data.length);
                                    if (resultadoValido(data))
                                    {

                                        //Oculta icono guardando
                                        $("#div_cargando").css("display", "none");
                                        $("#div_guardado").css("display", "inline");

                                        bootbox.alert('Se guardo la informaci\u00F3n correctamente.');
                                        //location.reload();

                                        $('#btnContacto').removeAttr('disabled');

                                    } else
                                    {
                                        bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                                        $("#div_cargando").css("display", "none");
                                        $("#div_error").css("display", "inline");
                                        $('#btnContacto').removeAttr('disabled');
                                    }
                                },
                                error: function (result) {
                                    bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                                    $("#div_cargando").css("display", "none");
                                    $("#div_error").css("display", "inline");
                                    $('#btnContacto').removeAttr('disabled');
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