/**
 * Funciones JavaScript para asignar compromisoso a los macroprocesos
 * @author BMOTTAG
 * @since  12/07/2016
 */
 
$(function(){ 

	$("#peso").blur(function(){
		if( $("#peso").val() !="" ){
			alert ("Tenga en cuenta que la suma de los seguimientos deber ser igual a: "+$("#peso").val());
		}

	});
	

	$("#peso").bloquearTexto().maxlength(2);
	
	$("#formulario").validate({
		//Reglas de Validacion
		rules : {
			pilar		: {	required	:	true },
			peso		: {	required	:	true },
			resultado	: {	required	:	true },
			compromisos : { required	:	true, maxlength: 1024},
			indicador : { required	:	true, maxlength: 1024}
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
			
			//valido que la suma de los seguimientos sea igual al peso asignado
			var idAcuerdo = $("#hddIdAcuerdo").val();
			var peso = $("#peso").val();
			var abril=verificar($("#abril").val());
			var agosto=verificar($("#agosto").val());
			var diciembre=verificar($("#diciembre").val());

			var total = parseInt(abril) + parseInt(agosto) + parseInt(diciembre);
			if(total != peso ){
				bootbox.alert('ERROR. El peso asignado no es igual a la suma de los seguimientos.');
			}else{
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
						url: base_url + "gh_evaluacion/guardarCompromiso",
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

										var url = base_url + "gh_evaluacion/compromiso/"+idAcuerdo;
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
			}
		}//if			
	});
});



    /**
     * Funcion para verificar los valores de los cuadros de texto. 
     */
    function verificar(numero)
    {
        if(numero==""){
            value="0";
        }else{
            value=numero;
		}

		return value;
    }