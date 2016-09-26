/**
 * Funciones JavaScript para asignar compromisoso a los macroprocesos
 * @author BMOTTAG
 * @since  12/07/2016
 */
 
$(function(){ 

	$("#aprobar").change(function () {
		if (this.value == 1) {
			$("#peso").val('');
			$("#observacion").val('')
			$("#porcentaje").css({display: "none"});
			$("#observ").css({display: "none"});
		} else {
			$("#porcentaje").css({display: "block"});
			$("#observ").css({display: "block"});
		}
	});
	

	$("#peso").bloquearTexto().maxlength(2);
	
	$("#formulario").validate({
		//Reglas de Validacion
		rules : {
			aprobar		: {	required	:	true },
			peso		: {	required	:	true },
			observacion : { required	:	true, maxlength: 255}
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
	
	$("#peso").bloquearTexto().maxlength(2);
	
	$("#btnGuardar").click(function(){		
	
		if ($("#formulario").valid() == true){
			
				var idAcuerdo = $("#hddIdAcuerdo").val();
			
				bootbox.confirm("Confirmar si desea guardar", function(result){  
				if (result) { 
				//Activa icono guardando
				$('#btnGuardar').attr('disabled','-1');
				$("#div_guardado").css("display", "none");
				$("#div_error").css("display", "none");
				$("#div_msj").css("display", "none");
				$("#div_cargando").css("display", "inline");
				
					$.ajax({
						type: "POST",	
						url: base_url + "gh_evaluacion/guardarAprobacion",
						data: $("#formulario").serialize(),
						dataType: "json",
						contentType: "application/x-www-form-urlencoded;charset=UTF-8",
						cache: false,
						
						success: function(data){
												
							if( data.result == "error" )
							{
								bootbox.alert(data.mensaje);
								$("#div_cargando").css("display", "none");
								$('#btnGuardar').removeAttr('disabled');							
								
								$("#span_msj").html(data.mensaje);
								$("#div_msj").css("display", "inline");
								return false;
							
							} 							
											
						  if( data.result )//true
							{	                                                        
								$("#div_cargando").css("display", "none");
								bootbox.alert("Solicitud guardada correctamente.", function() {
										$("#div_guardado").css("display", "inline");
										$('#btnGuardar').removeAttr('disabled');   

										var url = base_url + "gh_evaluacion/acuerdo/"+idAcuerdo;
										$(location).attr("href", url);
								});                                                                                                               						
							}
							else
							{
								bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
								$("#div_cargando").css("display", "none");
								$("#div_error").css("display", "inline");
								$('#btnGuardar').removeAttr('disabled');
							}	
						},
						error: function(result) {
							bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
							$("#div_cargando").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnGuardar').removeAttr('disabled');
						}
						
			
					});	
				}
				});	
		}//if			
	});
});