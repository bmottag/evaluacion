$(function(){

        $("#resultado").load(base_url + "menu/listaJefes");//lista de datos
        
	$("#formulario").validate({
	
		//Reglas de Validacion
		rules : {
			cmbDespacho		: {	required	:	true },
			cargo		: {	required	:	true }
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
					url: base_url + "menu/guardaJefe",
					
					data: $("#formulario").serialize(),
					dataType: "html",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
						if( resultadoValido(data) )
						{	
                                                        $("#div_cargando").css("display", "none");
                                                        bootbox.alert("Solicitud guardada correctamente.", function() {
                                                                $("#div_guardado").css("display", "inline");
                                                                $('#btnForm').removeAttr('disabled');   

                                                                var url = base_url + "menu/buscarUsuario";
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
	
});


function resultadoValido(data)
{
	if( (!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)) )
		return true;
	else
		return false;
}/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


