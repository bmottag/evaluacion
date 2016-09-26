$(function(){

        $("#resultado").load(base_url + "gh_evaluacion/admin_evaluacion/listaPilar");//lista de datos
		
	$("#pilar").convertirMayuscula();
        
	$("#formulario").validate({
	
		//Reglas de Validacion
		rules : {
			pilar		: {	required	:	true, maxlength:100 },
			definicion      : {	required	:	true, maxlength:1024 },
			estado       : {	required	:	true }
                        
                        
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
	$("#btnForm").click(function(){		
	
		if ($("#formulario").valid() == true){
	
                    bootbox.confirm("Confirmar si desea guardar", function(result){  
                        if (result) { 
			//Activa icono guardando
			$('#btnForm').attr('disabled','-1');
			$("#div_guardado").css("display", "none");
			$("#div_error").css("display", "none");
			$("#div_cargando").css("display", "inline");
			
				$.ajax({
					type: "POST",
					url: base_url + "gh_evaluacion/admin_evaluacion/guardaPilar",					
					
					data: $("#formulario").serialize(),
					dataType: "html",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
					//data=utf8_decode(data);
						//if(data ==="-ok-")
						//alert(data.length);
						if( resultadoValido(data) )
						{	
                                                        $("#div_cargando").css("display", "none");
                                                        bootbox.alert("Solicitud guardada correctamente.", function() {
                                                                $("#div_guardado").css("display", "inline");
                                                                $('#btnForm').removeAttr('disabled');   

                                                                var url = base_url + "gh_evaluacion/admin_evaluacion/pilar";
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