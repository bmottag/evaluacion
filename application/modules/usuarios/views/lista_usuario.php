<script>
	$(function(){ 

	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");

            $.ajax ({
                type: 'POST',
                url: base_url + 'usuarios/admin_usuarios/cargarModal',
                data: {'idDependenica': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});				
		
	});
</script>
<div class="container"> 
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						REPORTE GENERAL
					</h4>
				</div>
			</div>
		</div>			
	</div>
    
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="info">
						<td rowspan=2 class='text-center'><strong>Dependencia / Grupo</strong></td>
						<td colspan=2 class='text-center'><strong>Pol&iacute;tica</strong></td>
						<td rowspan=2 class='text-center'><strong>Informaci&oacute;n Acad&eacute;mica</strong></td>
						<td class='text-center'><strong>Form. Idioma</strong></td> 
						<td rowspan=2 class='text-center'><strong>Form. Dependientes</strong></td> 
						<td colspan=2 class='text-center'><strong>Form. Actividades</strong></td>
						<td colspan=2 class='text-center'><strong>Form.Mascotas</strong></td>
				</tr>
				<tr class="info">
						<td class='text-center'># Aceptaron</td> 
						<td class='text-center'># NO Aceptaron</td>

						<td class='text-center'># Diferente al español</td>
						
						<td class='text-center'># Con</td> 
						<td class='text-center'># Sin</td>
						
						<td class='text-center'># Con</td> 
						<td class='text-center'># Sin</td>
				</tr>
			<?php			
				foreach ($dependencias as $lista):
				
						$arrParam = array(
							"politica" => 1,
							"idDependencia" => $lista->CODIGO_DEPENDENCIA
						);
						$conteoConPolitica = $this->consultas_user_model->contar_usuario_politica($arrParam);//cantidad de usuarios que no aceptaron la politica
						
						$arrParam = array(
							"politica" => 2,
							"idDependencia" => $lista->CODIGO_DEPENDENCIA
						);
						$conteoSinPolitica = $this->consultas_user_model->contar_usuario_politica($arrParam);//cantidad de usuarios que no aceptaron la politica
						echo "<tr>";
						echo "<td >" . $lista->DESCRIPCION . "</td>";
						echo "<td class='text-center'>";
						$habilitar = $conteoConPolitica>0?"":"disabled";
			?>
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="<?php echo $lista->CODIGO_DEPENDENCIA; ?>" <?php echo $habilitar ?>>
							<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> <?php echo $conteoConPolitica; ?>
						</button>
			<?php
						echo "</td>";
						echo "<td class='text-center'>" . $conteoSinPolitica . "</td>"; 





$conteoSinPolitica = '--';
						
						
						
						
						
						echo "<td class='text-center'>" . $conteoSinPolitica . "</td>"; 
    /**
     * Inicio calculo formulario idioma
     */
						$arrParam = array(
							"idDependencia" => $lista->CODIGO_DEPENDENCIA
						);
						$conteo = $this->consultas_user_model->contar_usuario_idioma($arrParam);
						$conteo = $conteo?$conteo:0;
						
						echo "<td class='text-center'>" . $conteo . "</td>";   
						
    /**
     * Inicio calculo formulario de dependiente
     */
						$arrParam = array(
							"idDependencia" => $lista->CODIGO_DEPENDENCIA
						);
						$conteo = $this->consultas_user_model->contar_usuario_dependiente($arrParam);
						$conteo = $conteo?$conteo:0;
						
						echo "<td class='text-center'>" . $conteo . "</td>"; 
						
    /**
     * Inicio calculo formulario de actividades
     */
						$arrParam = array(
							"filtro" => "A.FK_ID_LUDICA <>",//filtro usuario con actividades
							"idDependencia" => $lista->CODIGO_DEPENDENCIA
						);
						$conteo = $this->consultas_user_model->contar_usuario_actividades($arrParam);
						$conteo = $conteo?$conteo:0;
						
						echo "<td class='text-center'>" . $conteo . "</td>"; 
						
						$arrParam = array(
							"filtro" => "A.FK_ID_LUDICA",//filtro usuario sin actividades
							"idDependencia" => $lista->CODIGO_DEPENDENCIA
						);
						$conteo = $this->consultas_user_model->contar_usuario_actividades($arrParam);
						$conteo = $conteo?$conteo:0;
						echo "<td class='text-center'>" . $conteo . "</td>"; 

						
    /**
     * Inicio calculo formulario de mascotas
     */
						$arrParam = array(
							"filtro" => "M.MASCOTA <>",//filtro usuario con mascotas
							"idDependencia" => $lista->CODIGO_DEPENDENCIA
						);
						$conteo = $this->consultas_user_model->contar_usuario_mascotas($arrParam);
						$conteo = $conteo?$conteo:0;
						
						echo "<td class='text-center'>" . $conteo . "</td>"; 
						
						$arrParam = array(
							"filtro" => "M.MASCOTA",//filtro usuario sin mascotas
							"idDependencia" => $lista->CODIGO_DEPENDENCIA
						);
						$conteo = $this->consultas_user_model->contar_usuario_mascotas($arrParam);
						$conteo = $conteo?$conteo:0;
						echo "<td class='text-center'>" . $conteo . "</td>"; 
						
						
						echo "</tr>";		
				endforeach;
			?>
		<!--		<tr >
					<td class="text-right"><strong>Total</strong></td>
					<td class="text-center"><strong><?php echo $conPolitica; ?></strong></td>
					<td class="text-center"><strong><?php echo $sinPolitica; ?></strong></td>
				</tr>-->
			</table>
		</div>
	</div>	

</div>

<!--INICIO Modal para adicionar  -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar MACROPROCESO -->