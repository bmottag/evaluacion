$(function(){
	
	/**
    * validacion del formulario de descuentos
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Agosto 24 / 2015
    */
	
	$("#NovNomina").validate({
		//Reglas de Validacion
		rules : {
			Territorial	: {	comboBox   :  '-'
			},
			quincena    : {	comboBox   :  '-'
			},
			periodo    	: {	comboBox   :  '-'
			}/*,
			tip_novedad    	: {	comboBox   :  '-'
			}*/
		},
		//Mensajes de validacion
		messages : {	
			Territorial	: {	comboBox   :  'Seleccione una opci&oacute;n'
			},
			quincena    : {	comboBox   :  'Seleccione una opci&oacute;n'
			},
			periodo    	: {	comboBox   :  'Seleccione una opci&oacute;n'
			}/*,
			tip_novedad    	: {	comboBox   :  'Seleccione una opci&oacute;n'
			}*/
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
	
	
	/**
    * guarda la solicitud de descuento.
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Agosto 19 / 2015
    */
	
	$("#btnbuscar").bind("click",function(){
		if ($("#NovNomina").valid() == true){
			$.ajax({
				type: "POST",
				url: base_url + "gh_novedadesnomina/gh_novNomina/BuscaNovedades",
				data: $("#NovNomina").serialize(),				
				dataType: "html",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,
				success: function(data){
					
					$("#ajxresult").html(data);
				}
			});
		}
	});
	
});