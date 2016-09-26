$(function () {
    $.validator.addMethod('validaCual', function (value, element, params) {
        var mascota = $('#mascota').val();
        if(mascota == '3' && value.length == 0) {
            return false;
        }
        return true;
    });
    
    $.validator.addMethod('validaMascota', function (value, element, params) {
        var mascota = $('#mascota').val();
        console.log(value);
        if(mascota != '99' && value.length == 0) {
            return false;
        }
        return true;
    });
    
    $("#resultado").load(base_url + "usuarios/listaMascota");//lista de datos
    
    $("#mascota").change(function () {
        $("#cual").val('');
        $("#mostrarCual").css({display: "none"});
        if (this.value == 99) {
            $("#cuantos").val('');
            $("#cuantos").attr('disabled', true);
        } else {
            $("#cuantos").attr('disabled', false);
            if (this.value == 3) {
                $("#mostrarCual").css({display: "block"});
            }
        }
    });

    $("#cuantos").bloquearTexto().maxlength(2);
    
    $("#formMascotas").validate({
        //Reglas de Validacion
        rules: {
            mascota: {required: true},
            cual: {validaCual: true},
            cuantos: {validaMascota: true}
        },
        messages: {
            mascota: { required: 'Debe seleccionar la mascota.' },
            cual: { validaCual: 'Debe seleccionar cuál mascota.' },
            cuantos: { validaMascota: 'Debe seleccionar cuantas mascotas.' }
        },
        errorPlacement: function (error, element) {
            element.after(error);
            error.css('display', 'inline');
            error.css('margin-left', '10px');
            error.css('color', "#FF0000");
            $(element).focus();
        },
        submitHandler: function (form) {
            return true;
        }
    });
    
    $("#btnMascota").click(function () {

        if ($("#formMascotas").valid() == true) {
            bootbox.confirm("Confirmar si desea guardar", function (result) {
                if (result) {
                    //Activa icono guardando
                    $('#btnMascota').attr('disabled', '-1');
                    $("#div_guardado").css("display", "none");
                    $("#div_error").css("display", "none");
                    $("#div_cargando").css("display", "inline");

                    $.ajax({
                        type: "POST",
                        url: base_url + "usuarios/guardaMascota",
                        data: $("#formMascotas").serialize(),
                        dataType: "html",
                        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                        cache: false,
                        success: function (data) {
                            //data=utf8_decode(data);
                            //if(data ==="-ok-")
                            //alert(data.length);
                            if (resultadoValido(data)) {
                                $("#div_cargando").css("display", "none");
                                bootbox.alert("Se guardo la informaci\u00F3n correctamente.", function () {
                                    $("#div_guardado").css("display", "inline");
                                    $('#btnMascota').removeAttr('disabled');

                                    var url = base_url + "usuarios/mascotas";
                                    $(location).attr("href", url);
                                });
                            } else {
                                bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                                $("#div_cargando").css("display", "none");
                                $("#div_error").css("display", "inline");
                                $('#btnMascota').removeAttr('disabled');
                            }
                        },
                        error: function (result) {
                            bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                            $("#div_cargando").css("display", "none");
                            $("#div_error").css("display", "inline");
                            $('#btnMascota').removeAttr('disabled');
                        }
                    });
                }
            });
        } else {
            bootbox.alert('Campos del formulario con errores. Revise y corrija.');
        }
    });
});



function resultadoValido(data) {
    if ((!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)))
        return true;
    else
        return false;
}
//EOC