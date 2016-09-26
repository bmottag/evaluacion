	/**
     * Lista de permisos filtrados por modulo
     * @author bmottag
     * @since  13/05/2016
     */


		$(document).ready(function() {

				$("#modulo").change(function() {
						$("#modulo option:selected").each(function() {
								var modulo= $("#modulo").val();
								if (modulo>0 || modulo!="-")
								{
									$.ajax
									({
										type: "POST",
										url: base_url + "menu/listaPermiso",
										data:{'identificador' : modulo},
										cache: false,
										success: function(data)
										{
											$("#permiso").html(data);
										}
									});
								}
								else 
								{
									var data="";
									$("#permiso").html(data);
								}
						});
				});
				
		});