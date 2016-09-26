$(function(){
	/**
     * Valores iniciales de los campos de Descuento.
     * @author Angela Liliana Rodriguez Mahecha
     * @since  Julio 07 / 2015
     */
	$("#txtNit").bloquearTexto().maxlength(15);
	$("#txtnumcuenta").bloquearTexto().maxlength(15);
	$("#txtCedula").bloquearTexto().maxlength(12);
	$("#txtCoddes").bloquearTexto().maxlength(10);
	$("#txtCuotas").bloquearTexto().maxlength(12);
	$("#txtValorCuota").bloquearTexto().maxlength(12);
	$("#datos_descuento").hide();
	
	//$('#descuentosnom').trigger("reset");
	/**
    * validacion del formulario de descuentos
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Agosto 19 / 2015
    */
	
	$("#descuentosnom").validate({
		//Reglas de Validacion
		rules : {
			txtCedula    : {	required   :  true 
			},
			acciondes    : {	required   :  true
			},
			txtCuotas    : {	required   :  true
			},
			txtValorCuota    : {	required   :  true
			},
			quincena    : {	comboBox   :  '-'
			},
			periodo    : {	comboBox   :  '-'
			}
		},
		//Mensajes de validacion
		messages : {	
			txtCedula    : {	required        :  "Debe digitar el n&uacute;mero de cedula " 
			},
			acciondes    : {	required   :  "Seleccione una acci&oacute;n para esta novedad"
			},
			txtCuotas    : {	required   :  'Indique el n&uacute;mero de cuotas'
			},
			txtValorCuota    : {	required   :  'Indique el valor de la cuota'
			},
			quincena    : {	comboBox   :  'Seleccione una opci&oacute;n'
			},
			periodo    : {	comboBox   :  'Seleccione una opci&oacute;n'
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
	
	$("#btnGenerardescuento").bind("click",function(){
		if ($("#descuentosnom").valid() == true){
			if(window.confirm('Est\u00e1 seguro de guardar la informaci\u00f3n consignada\n\nTenga en cuenta que no podr\u00e1 ser modificada despu\u00e9s del envi\u00f3 \ny que afectar\u00e1 la nomina'))
			{
				$.ajax({
					type: "POST",
					url: base_url + "gh_novedadesnomina/GenerarDescuento",
					data: $("#descuentosnom").serialize(),				
					dataType: "html",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					success: function(data){
						if (data=="<div class='alert alert-success' style='padding-top:10px;' role='alert'><h5>El descuento se radico exitosamente</h5></div>")
						{
							alert ("El descuento se radico exitosamente");
							$('#descuentosnom')[0].reset();
							location.reload();
						}
						$("#ajxresult").html(data);
					}
				});
			}
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
						$("#btnGenerardescuento").show();
					}
					else 
					{
						$("#btnGenerardescuento").hide();
					}
					$("#nombres").html(data);
				}
			});
		}
	});
	
	/**
    * Muestra el resultado del NIT digitada.
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Julio 15 / 2015
    */
	$("#txtNit").blur(function()
	{
		var valced= $("#txtNit").val();
		//alert ("aqui"+valced);
		if (valced>0 || valced!="")
		{
			$.ajax
			({
				type: "POST",
				url: base_url + "gh_novedadesnomina/buscanit",
				data:{'nit' : valced},
				cache: false,
				success: function(data)
				{
					//alert (data);
					if (data!="<br/><label><font color='red'>El NIT no existe</font></label>")
					{
						//alert ("aqui");
						$("#datos_descuento").show();
					}
					else 
					{
						$("#datos_descuento").hide();
					}
					$("#nombresnit").html(data);
					$("#txtCedula").focus();
				}
			});
		}
		else 
		{
			$("#datos_descuento").hide();
		}
	});
	
	/**
    * Muestra el resultado del codigo digitado.
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Agosto 19 / 2015
    */
	$("#txtCoddes").blur(function()
	{
		var valcod= $("#txtCoddes").val();
		//alert ("aqui"+valced);
		if (valcod>0 || valcod!="")
		{
			$.ajax
			({
				type: "POST",
				url: base_url + "gh_novedadesnomina/buscacodigodescuento",
				data:{'codigo' : valcod},
				cache: false,
				success: function(data)
				{
					//alert (data);
					if (data!="<br/><label ><font color='red'>El c&oacute;digo no existe</font></label>")
					{
						//alert ("aqui");
						$("#btnGenerardescuento").show();
					}
					else 
					{
						$("#btnGenerardescuento").hide();
					}
					$("#nomdescu").html(data);
				}
			});
		}
	});
	
	/**
    * Muestra el valor total del descuento.
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Julio 09 / 2015
    */
	$("#txtvaltot").blur(function()
	{
		var cantcuotas= $("#txtCuotas").val();
		var valtotal= $("#txtvaltot").val();
		//alert ("aqui"+valced);
		if ((cantcuotas>0 || cantcuotas!="") && (valcuota>0 || valcuota!="") )
		{
			$.ajax
			({
				type: "POST",
				url: base_url + "gh_novedadesnomina/TotalDescuento",
				data:{'cuotas' : cantcuotas, 
					'valtotal' : valtotal},
				cache: false,
				success: function(data)
				{
					$("#valcuota").html(data);
				}
			});
		}
	});
	
	/**
    * bloquea cambios por validacion de la accion del descuento.
    * @author Angela Liliana Rodriguez Mahecha
    * @since  Julio 09 / 2015
    */
	$("#acciondes").change(function()
	{
		var valor= $("#acciondes").val();
		//alert ("aqui"+valor);
		if (valor==2)
		{
			$("#txtCuotas").attr("disabled","disabled");
			$("#txtCuotas").val(0);
			$("#txtValorCuota").val(0);
		}
		else 
		{
			$("#txtCuotas").removeAttr("disabled");
		}
	});
	
	/**
	    * bloquea cambios por validacion de la accion del descuento.
	    * @author Angela Liliana Rodriguez Mahecha
	    * @since  Julio 09 / 2015
	    */
		$("#quincena").change(function()
		{
			var quincena= $("#quincena").val();
			var periodo=$("#periodo").val();
			var territorial=$("#hddterritorial").val();
			//alert ("quincena="+quincena+"periodo="+periodo);
			if (quincena != "-" && periodo != "-")
			{
				$.ajax
				({
					type: "POST",
					url: base_url + "gh_novedadesnomina/BuscaNovedades",
					data:{'quincena' : quincena, 
						  'periodo' : periodo,
						  'Territorial' : territorial},
					cache: false,
					success: function(data)
					{
						$("#listadoDes").html(data);
					}
				});
			}
			else 
			{
				var data="";
				$("#listadoDes").html(data);
			}
		});
		
		/**
	    * bloquea cambios por validacion de la accion del descuento.
	    * @author Angela Liliana Rodriguez Mahecha
	    * @since  Julio 09 / 2015
	    */
		$("#periodo").change(function()
		{
			var quincena= $("#quincena").val();
			var periodo=$("#periodo").val();
			var territorial=$("#hddterritorial").val();
			//alert ("quincena="+quincena+"periodo="+periodo);
			if (quincena != "-" && periodo != "-")
			{
				$.ajax
				({
					type: "POST",
					url: base_url + "gh_novedadesnomina/BuscaNovedades",
					data:{'quincena' : quincena, 
						  'periodo' : periodo,
						  'Territorial' : territorial},
					cache: false,
					success: function(data)
					{
						$("#listadoDes").html(data);
					}
				});
			}
			else 
			{
				var data="";
				$("#listadoDes").html(data);
			}
		});
	

});