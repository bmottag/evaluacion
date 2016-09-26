$(function(){
	
	
	/*$("#btnCertiCancelar").bind("click",function(){
		site_url = base_url+"gh_certificados"
		//alert (base_url);
		$(location).attr("href",site_url);
	});
 
	$("#btnCertiCancelar1").bind("click",function(){
		$(location).attr("href",base_url);
	});*/
	
	
	$("#btnGenerarSolicitud").bind("click",function(){
		
		var tipo_certi= $("#tipo_certi").val();
		//alert ("ingreso"+tipo_certi);
		//alert (base_url);
		if (tipo_certi=="" || tipo_certi==0 ){
			
			$("#ajxresult").html('<div class="alert alert-danger" style="padding-top:10px;" role="alert"><h5>Por favor verifique debe seleccionar un tipo de certificaci&oacute;n</h5></div>');
		}
		else 
		{
			//$("#ajxresult").html('<div style="padding-top:10px;" role="alert"><h5>Guardando...&nbsp;<img src="'+base_url+'/images/ajax-loader.gif"></h5></div>');
			$.ajax({
				type: "POST",
				url: base_url + "gh_certificados/GenerarSolicitud",
				data:{'tipo_certi' : tipo_certi 
					},				
				dataType: "html",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,
				success: function(data){
					$("#ajxresult").html('<div class="alert alert-success" style="padding-top:10px;" role="alert"><h5>'+data+'</h5></div>');
				}
			});
		}
	});
	
});