
$(function(){
	
	/*alert ("aqui");
	var d=new Date("31/22/2015");
	//var h=new Date("08/22/2015");
	alert (d);
	//alert (h);
	//alert ("esta "+h.getDay());
	alert ("esta "+d.getDay());
	
	//if ((h.getDay()==0) || (h.getDay()==6)) 
	if ((d.getDay()==0) || (d.getDay()==6))
	{
		alert ("dia es feriado");
	}
	else 
	{
		alert ("dia habil");
	}*/
	
	/**
     * Valores iniciales de los campos de Vacaciones.
     * @author Angela Liliana Rodriguez Mahecha
     * @since  Agosto 20 / 2015
     */
	$("#txtCedula").bloquearTexto().maxlength(12);
	$("#txtnomacto").bloquearTexto().maxlength(10);
	$("#fecha_acto").bloquearTexto().maxlength(10);
	$("#fecha_vacdesd").maxlength(10);
	$("#fecha_vachast").maxlength(10);
	$("#fecha_disdesd").maxlength(10);
	$("#fecha_dishast").maxlength(10);
	$("#txtdiastom").bloquearTexto().maxlength(2);
	$("#txtdiaspen").bloquearTexto().maxlength(2);
	//$("#datos_descuento").hide();
	
	//$('#formvacaciones').trigger("reset");
	$('#fecha_vacdesd').datepicker({		
		 dateFormat: 'dd/mm/yy',
		 minDate:'now',
		 onClose: function( selectedDate ) {
				$( "#fecha_vachast" ).datepicker( "option", "minDate", selectedDate );
			}
	});
	
	$('#fecha_vachast').datepicker({	
		 dateFormat: 'dd/mm/yy',
		 minDate:'now',
		 onClose: function( selectedDate ) {
				$( "#fecha_vacdesd" ).datepicker( "option", "maxDate", selectedDate );
			}
	});
	
	$('#fecha_disdesd').datepicker({	
		 dateFormat: 'dd/mm/yy',
		 minDate:'now',
		 onClose: function( selectedDate ) {
				$( "#fecha_dishast" ).datepicker( "option", "minDate", selectedDate );
			}
	});
	
	$('#fecha_dishast').datepicker({	
		 dateFormat: 'dd/mm/yy',
		 minDate:'now',
		 onClose: function( selectedDate ) {
				$( "#fecha_disdesd" ).datepicker( "option", "maxDate", selectedDate );
				var f1 =  $("#fecha_disdesd").val();
				var f2 = $("#fecha_dishast").val();
				var diastom = restaFechas(f1,f2);
				$("#txtdiastom").val(diastom);
				var faltan = 15 - diastom;
				$("#txtdiaspen").val(faltan);
				
				
				
				
				
			}
	});
	/**
    * validacion del formulario de descuentos
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Agosto 19 / 2015
    */
	
	$("#formvacaciones").validate({
		//Reglas de Validacion
		rules : {
			txtCedula    	: {	required   :  true 
			},
			accion     		: {	comboBox   :  '-'
			},
			fecha_vacdesd   : {	required   :  true, dateFormatValid: true
			},
			fecha_vachast   : {	required   :  true, dateFormatValid: true
			},
			fecha_disdesd   : {	required   :  true, dateFormatValid: true
			},
			fecha_dishast   : {	required   : true, dateFormatValid: true
			},
			txtdiastom	    : {	required   :  true
			},
			txtdiaspen  	: {	required   :  true
			},
			quincena    	: {	comboBox   :  '-'
			},
			periodo    		: {	comboBox   :  '-'
			}
		},
		//Mensajes de validacion
		messages : {	
			txtCedula    	: {	required   :  "Debe digitar el n&uacute;mero de cedula " 
			},	
			accion    		: {	comboBox   :  'Seleccione una opci&oacute;n'
			},
			fecha_vacdesd   : { required   :  "Seleccione una fecha", dateFormatValid:"Fecha debe tener formato dd/mm/yyyy"
			},
			fecha_vachast  	: { required   :  "Seleccione una fecha", dateFormatValid:"Fecha debe tener formato dd/mm/yyyy"
			},
			fecha_disdesd   : { required   :  "Seleccione una fecha", dateFormatValid:"Fecha debe tener formato dd/mm/yyyy"
			},
			fecha_dishast   : { required   :  "Seleccione una fecha", dateFormatValid:"Fecha debe tener formato dd/mm/yyyy"
			},
			txtdiastom	    : {	required   :  "Debe digitar el n&uacute;mero de dias tomados " 
			},
			txtdiaspen  	: {	required   :  "Debe digitar el n&uacute;mero de dias pendientes " 
			},
			quincena    	: {	comboBox   :  'Seleccione una opci&oacute;n'
			},
			periodo    		: {	comboBox   :  'Seleccione una opci&oacute;n'
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
	
	$("#btnGenerarVacaciones").bind("click",function(){
		/*var tipo_certi= $("#tipo_certi").val();
		//alert ("ingreso"+tipo_certi);
		//alert (base_url);
		if (tipo_certi=="" || tipo_certi==0 ){
			
			$("#ajxresult").html('<div class="alert alert-danger" style="padding-top:10px;" role="alert"><h5>Por favor verifique debe seleccionar un tipo de certificaci&oacute;n</h5></div>');
		}
		else 
		{*/
			//$("#ajxresult").html('<div style="padding-top:10px;" role="alert"><h5>Guardando...&nbsp;<img src="'+base_url+'/images/ajax-loader.gif"></h5></div>');
		if ($("#formvacaciones").valid() == true){
			$.ajax({
				type: "POST",
				url: base_url + "gh_novedadesnomina/gh_vacaciones/GuardarVacaciones",
				data: $("#formvacaciones").serialize(),				
				dataType: "html",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,
				success: function(data){
					if (data=="<div class='alert alert-success' style='padding-top:10px;' role='alert'><h5>Las Vacaciones se radicaron exitosamente</h5></div>")
					{
						alert ("Las Vacaciones se radicaron exitosamente");
						$('#formvacaciones')[0].reset();
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
						$("#btnGenerarVacaciones").show();
					}
					else 
					{
						$("#btnGenerarVacaciones").hide();
					}
					$("#nombres").html(data);
				}
			});
		}
	});
		
	restaFechas = function(f1,f2)
	 {
		 var aFecha1 = f1.split('/'); 
		 var aFecha2 = f2.split('/'); 
		 alert (aFecha1);
		 var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
		 var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
		 alert (fFecha1);
		 var dif = fFecha2 - fFecha1;
		 var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
		 return dias;
	 }
	
});
