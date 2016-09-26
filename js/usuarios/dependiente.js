$(function () {

    $("#resultado").load(base_url + "usuarios/listaDependiente");//lista de datos
	
	$( "#parentesco" ).change(function() {			
			$("#mostrar").css({ display: "block" });
			$("#txtNombres").prop( "disabled", false );
			$("#txtApellidos").prop( "disabled", false );
			$("#sexo").prop( "disabled", false );
			if( this.value == 99){//parentesco == ninguno
				$("#mostrar").css({ display: "none" });
				$("#txtNombres").prop( "disabled", true );
				$("#txtApellidos").prop( "disabled", true );
				$("#sexo").prop( "disabled", true );
				$("#txtNombres").val('');
				$("#txtApellidos").val('');
				$("#sexo").val('');
				$("#tipoDocumento").val('');
				$("#txtIdentificacion").val('');			
				$("#txtLugar").val('');
				$("#fechaNacimiento").val('');
				$("#subsidio").val('');
				$("#razonSocial").val('');
			}
	});
	
    
    $("#txtIdentificacion").bloquearTexto().maxlength(15);
    $("#txtNombres").bloquearNumeros().maxlength(50);
    $("#txtApellidos").bloquearNumeros().maxlength(50);
    $("#txtLugar").bloquearNumeros().maxlength(20);


    $("#formulario").validate({
        //Reglas de Validacion
        rules: {
            parentesco: {required: true},
            txtNombres: {required: true},
            txtApellidos: {required: true},
            sexo: {required: true},
            tipoDocumento: {required: true},
            txtIdentificacion: {required: true},
            txtLugar: {required: true},
            fechaNacimiento: {required: true},
            subsidio: {required: true},
            razonSocial: {required: true}
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

                    bootbox.confirm("Confirmar si desea guardar", function(result){  
                        if (result) { 
                            //Activa icono guardando
                            $('#btnGuardar').attr('disabled', '-1');
                            $("#div_guardado").css("display", "none");
                            $("#div_error").css("display", "none");
                            $("#div_cargando").css("display", "inline");

                            $.ajax({
                                type: "POST",
                                url: base_url + "usuarios/guardaDependiente",
                                data: $("#formulario").serialize(),
                                dataType: "html",
                                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                                cache: false,
                                success: function (data) {
                                    //data=utf8_decode(data);
                                    //if(data ==="-ok-")
                                    //bootbox.alert(data.length);
                                    if (resultadoValido(data))
                                    {
                                            $("#div_cargando").css("display", "none");
                                            bootbox.alert("Se guardo la informaci\u00F3n correctamente.", function() {
                                                    $("#div_guardado").css("display", "inline");
                                                    $('#btnGuardar').removeAttr('disabled');   
                                                    
                                                    var url = base_url + "usuarios/dependientes";
                                                    $(location).attr("href", url);
                                            });
                                    } else
                                    {
                                        bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                                        $("#div_cargando").css("display", "none");
                                        $("#div_error").css("display", "inline");
                                        $('#btnGuardar').removeAttr('disabled');
                                    }
                                },
                                error: function (result) {
                                    bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
                                    $("#div_cargando").css("display", "none");
                                    $("#div_error").css("display", "inline");
                                    $('#btnGuardar').removeAttr('disabled');
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