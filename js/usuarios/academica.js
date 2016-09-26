$(function() {

    $("#resultado").load(base_url + "usuarios/listaAcademica");//lista de datos

    $("#nivelEstudio").change(function() {
        $("#tituloEstudio").val('');
        $("#tituloEstudio").val('');
        $("#areaConocimmiento").val('');
        $("#graduado").val('');
        $("#annoEstudio").val('');
        $("#mostrar").css({display: "none"});
        $("#tituloEstudio").prop("disabled", true);
        $("#areaConocimmiento").prop("disabled", false);
        if (this.value != 99) {//nivel de estudio != ninguno
            $("#mostrar").css({display: "block"});
            $("#tituloEstudio").prop("disabled", false);
        }
        if (this.value <= 2) {//nivel de estudio = PRIMARIA - BACHILLER
            $("#areaConocimmiento").prop("disabled", true);
        }
    });

    $("#graduado").change(function() {
        $("#annoEstudio").val('');
        $("#anno").css({display: "none"});
        if (this.value == '' || this.value == 1) {
            $("#anno").css({display: "block"});
        }
    });

    $("#formAcademica").validate({
        //Reglas de Validacion
        rules: {
            nivelEstudio: {required: true},
            tituloEstudio: {required: true, maxlength: 100},
            annoEstudio: {required: true},
        },
        //Mensajes de error
        errorPlacement: function(error, element) {
            element.after(error);
            error.css('display', 'inline');
            error.css('margin-left', '10px');
            error.css('color', "#FF0000");

            //	$(element).focus();
        },
        submitHandler: function(form) {
            return true;

        }
    });
    $("#btnAcademica").click(function() {
        if ($("#formAcademica").valid() == true) {
            bootbox.confirm("Confirmar si desea guardar", function(result) {
                if (result) {
                    //Activa icono guardando
                    $('#btnAcademica').attr('disabled', '-1');
                    $("#div_guardado_academica").css("display", "none");
                    $("#div_error_academica").css("display", "none");

                    $.ajax({
                        type: "POST",
                        url: base_url + "usuarios/guardaAcademica",
                        data: $("#formAcademica").serialize(),
                        dataType: "html",
                        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                        cache: false,
                        success: function(data) {

                            if (resultadoValido(data))
                            {
                                $("#div_cargando").css("display", "none");
                                bootbox.alert("Se guardo la informaci\u00F3n correctamente.", function() {
                                    $("#div_guardado").css("display", "inline");
                                    $('#btnAcademica').removeAttr('disabled');

                                    var url = base_url + "usuarios/academica";
                                    $(location).attr("href", url);
                                });
                            }
                            else
                            {
                                bootbox.alert("Error al guardar. Intente nuevamente o actualice la p\u00e1gina.", function() {
                                    $("#div_error_academica").css("display", "inline");
                                    $('#btnAcademica').removeAttr('disabled');
                                });
                            }
                        },
                        error: function(result) {
                            bootbox.alert("Error al guardar. Intente nuevamente o actualice la p\u00e1gina.", function() {
                                $("#div_error_academica").css("display", "inline");
                                $('#btnAcademica').removeAttr('disabled');
                            });
                        }


                    });
                }
            });

        }//if			
    });

});

function resultadoValido(data){
    if ((!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)))
        return true;
    else
        return false;
}

//EOC