$(function(){
	/**
     * Valores iniciales de los campos de Vacaciones.
     * @author Angela Liliana Rodriguez Mahecha
     * @since  Agosto 20 / 2015
     */
	$("#txtCedula").bloquearTexto().maxlength(12);
	$("#fecha_efectivadesd").maxlength(10);
	$("#fecha_efectivahast").maxlength(10);
	$("#txtdias").bloquearTexto().maxlength(2);
	$("#txtnomacto").bloquearTexto().maxlength(10);
	$("#fecha_acto").bloquearTexto().maxlength(10);
	
	
	$('#fecha_efectivadesd').datepicker({		
		 dateFormat: 'dd/mm/yy',
		 minDate:'now',
		 onClose: function( selectedDate ) {
				$( "#fecha_efectivahast" ).datepicker( "option", "minDate", selectedDate );
			}
	});
	
	$('#fecha_efectivahast').datepicker({	
		 dateFormat: 'dd/mm/yy',
		 minDate:'now',
		 onClose: function( selectedDate ) {
				$( "#fecha_efectivadesd" ).datepicker( "option", "maxDate", selectedDate );
			}
	});
	
	
	/**
    * validacion del formulario de descuentos
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Agosto 19 / 2015
    */
	
	$("#formlicencias").validate({
		//Reglas de Validacion
		rules : {
			txtCedula    		: {	required   :  true 
			},
			accion     			: {	comboBox   :  '-'
			},
			fecha_efectivadesd  : {	required   :  true, dateFormatValid: true
			},
			fecha_efectivahast  : {	required   :  true, dateFormatValid: true
			},
			txtdias	    		: {	required   :  true
			},
			quincena    		: {	comboBox   :  '-'
			},
			periodo    			: {	comboBox   :  '-'
			}
		},
		//Mensajes de validacion
		messages : {	
			txtCedula    		: {	required   :  "Debe digitar el n&uacute;mero de cedula " 
			},	
			accion    			: {	comboBox   :  'Seleccione una opci&oacute;n'
			},
			fecha_efectivadesd  : { required   :  "Seleccione una fecha", dateFormatValid:"Fecha debe tener formato dd/mm/yyyy"
			},
			fecha_efectivahast  : { required   :  "Seleccione una fecha", dateFormatValid:"Fecha debe tener formato dd/mm/yyyy"
			},
			txtdias  			: {	required   :  "Debe digitar el total n&uacute;mero de dias" 
			},
			quincena    		: {	comboBox   :  'Seleccione una opci&oacute;n'
			},
			periodo    			: {	comboBox   :  'Seleccione una opci&oacute;n'
			}
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
	
	$("#btnGenerarLicencia").bind("click",function(){
		if ($("#formlicencias").valid() == true){
			$.ajax({
				type: "POST",
				url: base_url + "gh_novedadesnomina/gh_licencias/GuardarLicencia",
				data: $("#formlicencias").serialize(),				
				dataType: "html",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,
				success: function(data){
					if (data=="<div class='alert alert-success' style='padding-top:10px;' role='alert'><h5>La Licencia se radic&oacute; exitosamente</h5></div>")
					{
						alert ("La Licencia se radic\u00f3 exitosamente");
						$('#formlicencias')[0].reset();
						location.reload();
					}
					$("#ajxresult").html(data);
				}
			});
		}
	});
	

	/**
    * Muestra el resultado de la cedula digitada.
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Julio 09 / 2015
    */
	$("#txtCedula").blur(function()
	{
		var valced= $("#txtCedula").val();
		//alert ("aqui"+valced);
		if (valced>0 || valced!="")
		{
			$.ajax
			({
				type: "POST",
				url: base_url + "gh_novedadesnomina/buscafuncionario",
				data:{'cedula' : valced},
				cache: false,
				success: function(data)
				{
					//alert (data);
					if (data!="<br/><label ><font color='red'>El usuario no existe</font></label>")
					{
						//alert ("aqui");
						$("#btnGenerarLicencia").show();
					}
					else 
					{
						$("#btnGenerarLicencia").hide();
					}
					$("#nombres").html(data);
				}
			});
		}
	});
	
});
