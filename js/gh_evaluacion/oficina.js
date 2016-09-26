/**
 * Funciones JavaScript para asignar evaluador de la dependencia
 * @author BMOTTAG
 * @since  07/07/2016
 */
 
$(function(){ 

	$("#resultado").load(base_url + "gh_evaluacion/admin_evaluacion/listaOficina");//lista de datos

	$("#formulario").validate({
		
		//Reglas de Validacion
		rules : {
			dependencia		: {	required	:	true },
			evaluador       : {	required	:	true },
			estado       : {	required	:	true }
		},
		//Mensajes de error
		errorPlacement: function(error, element) {
			element.after(error);		        
			error.css('display','inline');
			error.css('margin-left','10px');				
			error.css('color',"#FF0000");
		},
		submitHandler: function(form) {
			return true;
			
		}
	});
	
	$("#btnForm").click(function(){		
	
		if ($("#formulario").valid() == true){
		
			bootbox.confirm("Confirmar si desea guardar", function(result){  
			if (result) { 
			//Activa icono guardando
			$('#btnForm').attr('disabled','-1');
			$("#div_guardado").css("display", "none");
			$("#div_error").css("display", "none");
			$("#div_msj").css("display", "none");
			$("#div_cargando").css("display", "inline");
			
				$.ajax({
					type: "POST",	
					url: base_url + "gh_evaluacion/admin_evaluacion/guardaOficina",	
					data: $("#formulario").serialize(),
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
                                            
						if( data.result == "error" )
						{
							bootbox.alert(data.mensaje);
							$("#div_cargando").css("display", "none");
							$('#btnForm').removeAttr('disabled');							
							
							$("#span_msj").html(data.mensaje);
							$("#div_msj").css("display", "inline");
							return false;
						
						} 

						
										
					  if( data.result )//true
						{	                                                        
							$("#div_cargando").css("display", "none");
							bootbox.alert("Solicitud guardada correctamente.", function() {
									$("#div_guardado").css("display", "inline");
									$('#btnForm').removeAttr('disabled');   

									var url = base_url + "gh_evaluacion/admin_evaluacion/oficina";
									$(location).attr("href", url);
							});                                                                                                               						
						}
						else
						{
							bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
							$("#div_cargando").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnForm').removeAttr('disabled');
						}	
					},
					error: function(result) {
						bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
						$("#div_cargando").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnForm').removeAttr('disabled');
					}
					
		
				});	
			}
			});			
		}//if			
	});
});