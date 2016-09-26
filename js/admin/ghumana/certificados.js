$(function(){
	
	var checkAll = false;
	
	$("#txtBuscarCertificado").bloquearTexto().maxlength(15);
	
	/**************************************************************************************
	 * Función para marcar/desmarcar todos los checkbox de notificacion de certificados
	 * @author Daniel M. Díaz
	 * @since  09 Julio / 2015  
	 */
	$("#btnMarcarTodos").bind("click",function(){
		if (checkAll){
			$("input:checkbox").each(function(){											
				$(this).prop("checked", false);				
			});
			checkAll = false;
		}
		else{
			$("input:checkbox").each(function(){											
				$(this).prop("checked", true);				
			});
			checkAll = true;
		}
	});
	
	$("#btnNotificar").bind("click",function(){
		var checkString = "";
		$("input:checkbox").each(function(){											
			if($(this).is(":checked")) {  
				checkString = checkString + $(this).attr("value") + ",";
			}
		});		
		if (checkString!=""){
			checkString = checkString.substring(0, checkString.length - 1);
			$("#ajxresult").html('<div style="padding-top:10px;" role="alert"><h5>Enviando...&nbsp;<img src="'+base_url+'/images/ajax-loader.gif"></h5></div>');
			$.ajax({
				type: "POST",
				url: base_url + "admin/ajaxEnviarNotificaciones",
				data: {'string': checkString },					
				dataType: "html",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,
				success: function(data){
					location.reload();
					$("#ajxresult").html('<div class="alert alert-success" role="alert"><strong>Notificaci&oacute;n Enviada</strong> Se han enviado los correos de notificaci&oacute;n exitosamente.</div>');
				}
			});
		}
	});
	
	
	/*************************************************************************************
	 * Función para la búsqueda de certificaciones a partir del número de identificacion
	 * @author Daniel M. Díaz
	 * @since  09 Julio / 2015
	 */
	$("#btnBuscarCertificados").bind("click",function(){
		if ($("#txtBuscarCertificado").val()!='' && $("#txtBuscarCertificado").val()!=0){
			$("#certificaciones").html('<div style="padding-top:10px;"><h5>Cargando...&nbsp;<img src="'+base_url+'/images/ajax-loader.gif"></h5></div>');		
			$.ajax({
				type: "POST",
				url: base_url + "admin/ajaxBusquedaCertificados",
				data: {'numid':$("#txtBuscarCertificado").val()},					
				dataType: "html",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,
				success: function(data){
					$("#certificaciones").html(data);
					$("#btnMarcarTodos").bind("click",function(){
						if (checkAll){
							$("input:checkbox").each(function(){											
								$(this).prop("checked", false);				
							});
							checkAll = false;
						}
						else{
							$("input:checkbox").each(function(){											
								$(this).prop("checked", true);				
							});
							checkAll = true;
						}
					});
					$("#btnNotificar").bind("click",function(){
						var checkString = "";
						$("input:checkbox").each(function(){											
							if($(this).is(":checked")) {  
								checkString = checkString + $(this).attr("value") + ",";
							}
						});
						if(checkString!=""){
							checkString = checkString.substring(0, checkString.length - 1);
							$("#ajxresult").html('<div style="padding-top:10px;" role="alert"><h5>Enviando...&nbsp;<img src="'+base_url+'/images/ajax-loader.gif"></h5></div>');
							$.ajax({
								type: "POST",
								url: base_url + "admin/ajaxEnviarNotificaciones",
								data: {'string': checkString },					
								dataType: "html",
								contentType: "application/x-www-form-urlencoded;charset=UTF-8",
								cache: false,
								success: function(data){
									location.reload();
									$("#ajxresult").html('<div class="alert alert-success" role="alert"><strong>Notificaci&oacute;n Enviada</strong> Se han enviado los correos de notificaci&oacute;n exitosamente.</div>');
								}
							});
						}
					});
				}
			});
		}
		else{
			location.reload();
		}
	});
		
	$("#txtBuscarCertificado").bind("keypress", function(e) {
	    if(e.which==13){
	    	if ($("#txtBuscarCertificado").val()!='' && $("#txtBuscarCertificado").val()!=0){
	    		$("#certificaciones").html('<div style="padding-top:10px;" role="alert"><h5>Cargando...&nbsp;<img src="'+base_url+'/images/ajax-loader.gif"></h5></div>');
	    		$.ajax({
					type: "POST",
					url: base_url + "admin/ajaxBusquedaCertificados",
					data: {'numid':$("#txtBuscarCertificado").val()},					
					dataType: "html",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					success: function(data){
						$("#certificaciones").html(data);	
						$("#btnMarcarTodos").bind("click",function(){
							if (checkAll){
								$("input:checkbox").each(function(){											
									$(this).prop("checked", false);				
								});
								checkAll = false;
							}
							else{
								$("input:checkbox").each(function(){											
									$(this).prop("checked", true);				
								});
								checkAll = true;
							}
						});
						$("#btnNotificar").bind("click",function(){
							var checkString = "";
							$("input:checkbox").each(function(){											
								if($(this).is(":checked")) {  
									checkString = checkString + $(this).attr("value") + ",";
								}
							});							
							if(checkString!=""){
								checkString = checkString.substring(0, checkString.length - 1);
								$("#ajxresult").html('<div style="padding-top:10px;" role="alert"><h5>Enviando...&nbsp;<img src="'+base_url+'/images/ajax-loader.gif"></h5></div>');
								$.ajax({
									type: "POST",
									url: base_url + "admin/ajaxEnviarNotificaciones",
									data: {'string': checkString },					
									dataType: "html",
									contentType: "application/x-www-form-urlencoded;charset=UTF-8",
									cache: false,
									success: function(data){
										location.reload();
										$("#ajxresult").html('<div class="alert alert-success" role="alert"><strong>Notificaci&oacute;n Enviada</strong> Se han enviado los correos de notificaci&oacute;n exitosamente.</div>');
									}
								});
							}							
						});
					}
				});
	    	}
	    	else{	    		
	    		location.reload();
	    	}
	    }
	}); 
	
	
	
});//EOF