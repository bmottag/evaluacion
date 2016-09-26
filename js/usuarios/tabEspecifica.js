$(function(){
    
            $("#departamento").change(function() {
            $("#departamento option:selected").each(function() {
                var departamento= $("#departamento").val();
                if (departamento>0 || departamento!="-")
                {
                    $.ajax
                    ({
                        type: "POST",
                        url: base_url + "usuarios/listaDesplegable",
                        data:{'identificador' : departamento},
                        cache: false,
                        success: function(data)
                        {
                            $("#municipio").html(data);
                        }
                    });
                }
                else 
                {
                    var data="";
                    $("#municipio").html(data);
                }
            });
        });
		
        $("#sexo").change(function () {
            if (this.value != 'M') {
                $("#libretaMilitar").val('');
                $("#claseLibreta").val('');
                $("#distritoMilitar").val('');
                $("#lugarExpedicion").val('');
                $("#libreta").css({display: "none"});
            } else {
                $("#libreta").css({display: "block"});
            }
        });
		

	$("#txtCelular").bloquearTexto().maxlength(10);
	$("#distritoMilitar").bloquearTexto().maxlength(2);
	
	$("#formEspecifico").validate({
	
		//Reglas de Validacion
		rules : {
            ciudadResidencia: {required: true},
            txtDireccion: {required: true, maxlength: 100},
            txtBarrio: {required: true, maxlength: 50},
            txtCorreoPersonal: {required: true, email: true},
            txtCelular: {required: true},
            sexo			:{required		:	true},
			municipio		:{required		:	true},
			fechaNacimiento		: {	required	:	true, maxlength:100 },
			tipoSangre		: {	required	:	true, maxlength:50 },
			vivienda       		: {	required	:	true },
			licencia  		: {	maxlength:20},
			pension                 : {	maxlength:100 },
			eps                     : {	maxlength:100 },
                        arp                     : {	maxlength:100 },
			compensacion            : {	maxlength:100 },
			adminARP                : {	maxlength:100 },
                        adminAFP                : {	maxlength:100 },
                        alergia                 : {	maxlength:100 },
			enfermedad              : {	maxlength:100 },
                        discapacidad            : {	maxlength:100 }
                        
                        
		},	
		//Mensajes de error
		errorPlacement: function(error, element) {
			element.after(error);		        
			error.css('display','inline');
			error.css('margin-left','10px');				
			error.css('color',"#FF0000");
			
		//	$(element).focus();
		},
		
		submitHandler: function(form) {
			return true;
			
		}
	});
	$("#btnEspecifica").click(function(){		
	
		if ($("#formEspecifico").valid() == true){
	
			bootbox.confirm("Confirmar si desea guardar", function(result){  
			if (result) { 
			//Activa icono guardando
			$('#btnEspecifica').attr('disabled','-1');
			$("#div_guardado").css("display", "none");
			$("#div_error").css("display", "none");
			$("#div_cargando").css("display", "inline");
			
				$.ajax({
					type: "POST",
					url: base_url + "usuarios/guardaEspecifica",					
					
					data: $("#formEspecifico").serialize(),
					dataType: "html",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
					//data=utf8_decode(data);
						//if(data ==="-ok-")
						//alert(data.length);
						if( resultadoValido(data) )
						{	
							
							//Oculta icono guardando
							$("#div_cargando").css("display", "none");
							$("#div_guardado").css("display", "inline");
							
							bootbox.alert('Se guardo la informaci\u00F3n correctamente.');
							//location.reload();
							
							$('#btnEspecifica').removeAttr('disabled');
							
						}
						else
						{
							bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
							$("#div_cargando").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnEspecifica').removeAttr('disabled');
						}	
					},
					error: function(result) {
                                                bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
						$("#div_cargando").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnEspecifica').removeAttr('disabled');
					}
					
		
				});	
                        }
                    });
			
                } else {
                    bootbox.alert('Campos del formulario con errores. Revise y corrija.');
                }			
	});	
	
});//EOC



function resultadoValido(data)
{
	if( (!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)) )
		return true;
	else
		return false;
}