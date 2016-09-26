/**
 * Funciones JavaScript para modulo actos administrativos de gestión humana (Seccion de Busqueda de Actos Administrativos)
 * @author dmdiazf	
 * @since  25/08/2015
 */
 
	$(function(){
		
		// combo anidado de firma / actos
		$("#cmbTipoFirma").cargarCombo("cmbDescAAdmin", base_url + "gh_actosadmin/getTiposActosAdmin");
		
		//Configuracion de JQGrid
		$.jgrid.defaults.width = 1200;
		$.jgrid.defaults.styleUI = 'Bootstrap';
		$.jgrid.defaults.responsive = true;
		
		//Ejecuta Ajax JSON para llenar los datos del grid jquery por primera vez
		var numrad = $("#txtNumRadicado").val(); 		  //Numero Radicado			
		var fecsold = $("#txtFecSolicitudDesde").val();   //Fecha de Solicitud Desde
		var fecsolh = $("#txtFecSolicitudHasta").val();   //Fecha de Solicitud Hasta
		var fecradd = $("#txtFecRadicadoDesde").val();    //Fecha de Radicado Desde
		var fecradh = $("#txtFecRadicadoHasta").val();    //Fecha de Radicado Hasta
		var tipofir = $("#cmbTipoFirma").val();           //Tipo de Firma
		var descadm = $("#cmbDescAAdmin").val(); 		  //Descripcion Acto Administrativo
		var observa = $("#txaObservacionesAAdmin").val(); //Observaciones
		var estado =  $("#hd_est").val();									  
		var interfaz =  $("#hd_interf").val();
		var usuario = 0;
		var data = new Array(numrad,fecsold,fecsolh,fecradd,fecradh,tipofir,descadm,observa,estado,usuario,interfaz);
		
		$("#jqGrid").jqGrid({
			//url: base_url + "gh_actosadmin/gh_actosadmin/jsonQuery",
			url: generateGetURL("gh_actosadmin/gh_actosadmin/busquedaActosAdminAJAX/", data),						
			datatype: "json",
			colModel: [
			    { label: 'Nro.<br/>Radic.', name: 'nrorad', width: 65, sorttype: 'number' },
				{ label: 'Fecha<br/>Digita', name: 'fechDigita', width: 90 },
				{ label: 'D&iacute;as<br>desde<br>digita', name: 'diasDesdeIni', width: 60 },
				{ label: 'Fecha<br/>Solicitud', name: 'fecsol', width: 90 },
				{ label: 'Fecha<br/>ORFEO', name: 'fecorfeo', width: 90 },
				{ label: 'Tipo Firma', name: 'tipofirma', width: 138 },				
				{ label: 'Desc. Acto Admin', name: 'descadm', width: 185 },
				{ label: 'Fecha<br>&Uacute;ltima<br/>Asignaci&oacute;n', name: 'fecasign', width: 90 },
				{ label: 'D&iacute;as<br>&Uacute;ltima<br/>Asignaci&oacute;n', name: 'diast', width: 60 },
				{ label: 'Observaci&oacute;n', name: 'observ', width: 155 },				
				{ label: 'Devuelta', name: 'devol', width: 70 },
				{ label: 'Opciones', name: 'opc', width: 100 }								
			],
			
			viewrecords: true,  //show the current page, data rang and total records on the toolbar
			shrinkToFit: false, //Muestra la barra de desplazamiento horizontal
			width: 1200,
			height: 400,
			rowNum: 10,
			loadonce: true, // this is just for the demo
			pager: "#jqGridPager"
		});
		
		//Configuracion formulario
		$("#txtNumRadicado").bloquearTexto().maxlength(10);
		$("#txtFecSolicitudDesde").datepicker({dateFormat:"dd/mm/yy"});
		$("#txtFecSolicitudHasta").datepicker({dateFormat:"dd/mm/yy"});
		$("#txtFecRadicadoDesde").datepicker({dateFormat:"dd/mm/yy"});
		$("#txtFecRadicadoHasta").datepicker({dateFormat:"dd/mm/yy"});
		
		
		//Función que se ejecuta al hacer click sobre el botón de busqueda de actos administrativos
		//@author: dmdiazf
		//@since: 25/08/2015
		$("#btnBuscarAAdmin").bind("click",function(){	
			
			$.ajax({ // verifica si hay sesion
					type: "POST",
					url: base_url + "gh_actosadmin/validaSesion",										
					dataType: "html",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
					
						if( resultadoValido(data) )
						{	
							
							var numrad = $("#txtNumRadicado").val(); 		  //Numero Radicado			
							var fecsold = $("#txtFecSolicitudDesde").val();   //Fecha de Solicitud Desde
							var fecsolh = $("#txtFecSolicitudHasta").val();   //Fecha de Solicitud Hasta
							var fecradd = $("#txtFecRadicadoDesde").val();    //Fecha de Radicado Desde
							var fecradh = $("#txtFecRadicadoHasta").val();    //Fecha de Radicado Hasta
							var tipofir = $("#cmbTipoFirma").val();           //Tipo de Firma
							var descadm = $("#cmbDescAAdmin").val(); 		  //Descripcion Acto Administrativo
							var observa = $("#txaObservacionesAAdmin").val(); //Observaciones
							var estado =  $("#hd_est").val();		
							var interfaz =  $("#hd_interf").val();
							var usuario = 0;						
							var data = new Array(numrad,fecsold,fecsolh,fecradd,fecradh,tipofir,descadm,observa,estado,usuario,interfaz);
							$("#jqGrid").setGridParam({
								url: generateGetURL("gh_actosadmin/gh_actosadmin/busquedaActosAdminAJAX/", data), 
								datatype:'json'
							}).trigger('reloadGrid',[{page:1}]);
						}
						else{
							alert ('La sesi\u00f3n termin\u00f3. Vuelva a ingresar por favor.');
							location.reload();
							
						}
						
						
					},
					error: function(result) {
						 bootbox.alert('Error al buscar. Intente nuevamente o actualice la p\u00e1gina.');
						
					}
					
		
				});
		
												
		});
		
		
		
	}); //EOC
	

function linkTramitarSolicitud(id_acto_admin, tipo_tramite_act,interfaz)
{

	$.ajax({
		type: "POST",
		url: base_url + "gh_actosadmin/tramiteActoAdminAjax",
		data: { 'id_acto_admin':id_acto_admin, 'tipo_tramite_act':tipo_tramite_act, 'interfaz':interfaz },
		dataType: "html",
		contentType: "application/x-www-form-urlencoded;charset=UTF-8",
		cache: false,		
		success: function(data){
		  	var url = base_url + "gh_actosadmin/tramiteActoAdmin";    
			$(location).attr("href",url);
		},
		error: function(result) {
			 bootbox.alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
		}
		
	
	});	

}
function resultadoValido(data)
{
	if( (!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)) )
		return true;
	else
		return false;
}