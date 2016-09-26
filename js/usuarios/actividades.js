$(function(){

        $("#tipoLudica").change(function() {
                        $("#tipoLudica option:selected").each(function() {
                                        var tipoLudica= $("#tipoLudica").val();
                                        if (tipoLudica>0 || tipoLudica!="-")
                                        {
                                                $.ajax
                                                ({
                                                        type: "POST",
                                                        url: base_url + "usuarios/listaLudica",
                                                        data:{'identificador' : tipoLudica},
                                                        cache: false,
                                                        success: function(data)
                                                        {
                                                                $("#ludica").html(data);
                                                        }
                                                });
                                        }
                                        else 
                                        {
                                                var data="";
                                                $("#ludica").html(data);
                                        }
                        });
        });

        $("#resultado").load(base_url + "usuarios/listaActividad");//lista de datos
        
        $( "#ludica" ).change(function() {
                $("#cual").val('');
                $("#mostrarCual").css({ display: "none" });
                if( this.value == 99){
                    $("#mostrarCual").css({ display: "block" });
                }
        });
        
        $("#horas").bloquearTexto().maxlength(3);
	
	$("#formActividades").validate({
	
		//Reglas de Validacion
		rules : {
			tipoLudica		: {	required	:	true },
                        cual                    : {	maxlength:30 },
			ludica                  : {	required	:	true, maxlength:100 },
			horas   		: {	required	:	true, maxlength:3 }
                        
                        
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
	$("#btnActividad").click(function(){		
	
		if ($("#formActividades").valid() == true){
	
                    bootbox.confirm("Confirmar si desea guardar", function(result){  
                        if (result) { 
			//Activa icono guardando
			$('#btnActividad').attr('disabled','-1');
			$("#div_guardado").css("display", "none");
			$("#div_error").css("display", "none");
			$("#div_cargando").css("display", "inline");
			
				$.ajax({
					type: "POST",
					url: base_url + "usuarios/guardaActividad",					
					
					data: $("#formActividades").serialize(),
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
                                                        bootbox.alert("Se guardo la informaci\u00F3n correctamente.", function() {
                                                                $("#div_guardado").css("display", "inline");
                                                                $('#btnActividad').removeAttr('disabled');   

                                                                var url = base_url + "usuarios/actividades";
                                                                $(location).attr("href", url);
                                                        });                                                       
						}
						else
						{
                                                        bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
							$("#div_cargando").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnActividad').removeAttr('disabled');
						}	
					},
					error: function(result) {
                                                bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
						$("#div_cargando").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnActividad').removeAttr('disabled');
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