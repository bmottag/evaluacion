<script>
	$(function(){ 

		$(".btn-primary").click(function () {	
				var oID = $(this).attr("id");

				$.ajax ({
					type: 'POST',
					url: base_url + 'gh_evaluacion/cargarModal_aprobacion',
					data: {'idModal': oID},
					cache: false,
					success: function (data) {
						$('#tablaDatos').html(data);
					}
				});
		});			
		
	});
</script>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						ACUERDO
					</h4>
				</div>
			</div>
		</div>			
	</div>
		<div class="alert alert-info" role="alert">
			<strong>Detalle </strong>del acuerdo. Puede visualizar los macroprocesos, los compromisos y el seguimiento realizado. Puede descargar el acuerdo en formato PDF.
			<br><strong>Bot&oacute;n "Aprobar": </strong> Permite aprobar o desaprobar el seguimiento una vez se realice. En caso de desaprobarse debe indicar el nuevo porcentaje de cumplimiento y colocar la observaci&oacute;n.
		</div>
    
<!--INICIO DATOS DEPENDENCIA -->
    <div class="well">
        <div class="row">
            <div class="col-md-5">	
                    <strong class='text-error'>DEPENDENCIA / TERRITORIAL:</strong><br />
                    <?php echo $acuerdo[0]->DESCRIPCION; ?>
					
					<?php 
						if($acuerdo[0]->TIPO_GERENTE_PUBLICO == 1)//gerente publico = direcciones territoriales
						{
							//informacion de los parcentajes y pesos para el area
							$info_area = $this->consultas_generales->get_consulta_basica('EVAL_PARAM_AREA', 'AREA');
							foreach ($info_area as $area):
								echo '<br><strong>' . $area['AREA'] . '</strong> : ' . $area['PORCENTAJE_AREA'] . '%';
							endforeach;
						}
					?>
					<br><br><a class="btn btn-success" href=" <?php echo base_url().'gh_evaluacion/asignarMacro/'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a>       
            </div>
            <div class="col-md-4">
                    <strong class='text-error'>ID ACUERDO: </strong><?php echo $acuerdo[0]->ID_ACUERDO; ?><br/>
                    <strong class='text-error'>Vigencia: </strong><?php echo $acuerdo[0]->VIGENCIA; ?><br/>
                    <strong class='text-error'><?php echo $usuarioEvaluador['cargo'];?>: </strong><?php echo $usuarioEvaluador['nom_usuario'] . ' ' . $usuarioEvaluador['ape_usuario'];?><br/>
                    <strong class='text-error'>Gerente P&uacute;blico: </strong><?php echo $usuarioJefe['nom_usuario'] . ' ' . $usuarioJefe['ape_usuario'];?>
            </div>
            <div class="col-md-3">
                    <strong class='text-error'>DESCARGAR DOCUMENTOS:</strong><br />
					<?php if($completa){ ?>
						<a href='<?php echo base_url('gh_evaluacion/generaAcuerdoPDF/' . $acuerdo[0]->ID_ACUERDO); ?>'><img src='<?php echo base_url_images('pdf.png'); ?>' >&nbsp;Descargar Compromisos</a><br>
						<a href='<?php echo base_url('gh_evaluacion/generaPDF/' . $acuerdo[0]->ID_ACUERDO); ?>'><img src='<?php echo base_url_images('pdf.png'); ?>' >&nbsp;Descargar Acuerdo</a><br>
						<a href='<?php echo base_url('gh_evaluacion/compromisosAdicionales/' . $acuerdo[0]->ID_ACUERDO); ?>'><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Calificar Compromisos Adicionales</a>
					<?php }else{
						echo "Debe finalizar la asignación de compromisos.";
					}?>				
            </div>
        </div>
    </div>
<!--FIN DATOS DEPENDENCIA -->
    
	<div class="row">
		<div class="col-md-12">
			<?php
				foreach ($macro as $lista):
						echo "<table class='table table-bordered table-striped table-hover table-condensed'>";
						echo "<tr class='info' colspan=9>";
						echo "<td class='text-center' colspan=9><strong>" . strtoupper($lista->MACROPROCESO) . "<br>Peso Asignado : </strong>" . $lista->PESO_ASIGNADO . " </td>";
						echo "</tr>";

						//lista de compromisos programados
						$info_compromisos = $this->consultas_eval_model->get_asignacion_compromiso($lista->ID_ASIGNAR_MACRO);
						if($info_compromisos)
						{ 
			?>
								<tr class="info">
									<td class='text-center' colspan=6><strong>CONCERTACI&Oacute;N DE COMPROMISOS</strong></td>
									<td class='text-center' colspan=3><strong>SEGUIMIENTO Y EVALUACI&Oacute;N</strong></td>
								</tr>
								<tr class="active">
									<th class='text-center'>PILAR ESTRAT&Eacute;GICO</th>
									<th class='text-center'>DEFINICI&Oacute;N DEL PILAR ESTRAT&Eacute;GICO</th>
									<th class='text-center'>COMPROMISOS INSTITUCIONALES</th>
									<th class='text-center'>PESO</th>
									<th class='text-center'>RESTULTADO ESPERADO</th>
									<th class='text-center'>INDICADOR Y/O EVIDENCIA RESULTADO</th>
									<th class='text-center'>ABRIL</th>
									<th class='text-center'>AGOSTO</th>
									<th class='text-center'>DICIEMBRE</th>
								</tr>
				<?php 
							foreach ($info_compromisos as $datos):                            
								echo "<tr>";
								echo "<td style='vertical-align: middle'><small>" . $datos['PILAR'] . "</small></td>";
								echo "<td style='vertical-align: middle'><small>" . $datos['DEFINICION_PILAR'] . "</small></td>";
								echo "<td style='vertical-align: middle'><small>" . $datos['COMPROMISO'] . "</small></td>";
								echo "<td style='vertical-align: middle' class='text-center'><small>" . $datos['PESO_PILAR'] . "</small></td>";
								echo "<td style='vertical-align: middle' class='text-center'><small>";
								if($datos['RESULTADO_ESPERADO']==1){ echo "Nominal"; }else{ echo "Porcentual"; }
								echo "</small></td>";
								echo "<td style='vertical-align: middle'><small>" . $datos['INDICADOR'] . "</small></td>";
								echo "<td class='text-center'><small>";
								//habilitar boton solo si el director o el subdirecor
								$deshabilitar = 'disabled';
								if($codDependencia<3){
									$deshabilitar = "";
								}
								if(isset($datos['ESPERADO_ABRIL']) && $datos['ESPERADO_ABRIL'] != 0 )
								{
									echo "<p class='bg-info'><strong>Esperado: </strong><br>" . $datos['ESPERADO_ABRIL'] . "</p>";
									echo "<hr>";
									if(isset($datos['SEGUIMIENTO_ABRIL']))
									{
										echo "<p class='bg-success'><strong>SEGUIMIENTO</strong>";
										echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEGUIMIENTO_ABRIL'];//Cumplimiento
										echo "<br><strong>Avance:</strong><br>" . $datos['AVANCE_ABRIL'] . "</p>";
										echo "<hr>";
										$idModal = $datos['ID_ASIGNAR_PILAR'] . "-ABRIL";
										if($datos['APROBAR_ABRIL'] == 1){//si se aprobo mostrar informacion de lo contrario mostrar informacion
											echo "<p class='bg-primary'><strong>APROBADO</strong></p>";//Aprobado
										}elseif($datos['APROBAR_ABRIL'] == 2){
											echo "<p class='bg-danger'><strong>DESAPROBADO</strong>";//Desaprobado
											echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEG_EVALUADOR_ABRIL'];
											echo "<br><strong>Observaci&oacute;n:</strong><br>" . $datos['OBS_EVALUADOR_ABRIL'] . "</p>";
										}else{

							?>
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal" id="<?php echo $idModal; ?>" <?php echo $deshabilitar; ?> >
											Aprobar <span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span>
										</button>
							<?php
										}
									}
								}else{echo "----";}
								echo "</small></td>";
								echo "<td class='text-center'><small>";
								if(isset($datos['ESPERADO_AGOSTO']) && $datos['ESPERADO_AGOSTO'] != 0 )
								{
									echo "<p class='bg-info'><strong>Esperado: </strong><br>" . $datos['ESPERADO_AGOSTO'] . "</p>";
									echo "<hr>";
									if(isset($datos['SEGUIMIENTO_AGOSTO']))
									{
										echo "<p class='bg-success'><strong>SEGUIMIENTO</strong>";
										echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEGUIMIENTO_AGOSTO'];//Cumplimiento
										echo "<br><strong>Avance:</strong><br>" . $datos['AVANCE_AGOSTO'] . "</p>";
										echo "<hr>";
										$idModal = $datos['ID_ASIGNAR_PILAR'] . "-AGOSTO";
										if($datos['APROBAR_AGOSTO'] == 1){//si se aprobo mostrar informacion de lo contrario mostrar informacion
											echo "<p class='bg-primary'><strong>APROBADO</strong></p>";//Aprobado
										}elseif($datos['APROBAR_AGOSTO'] == 2){
											echo "<p class='bg-danger'><strong>DESAPROBADO</strong>";//Desaprobado
											echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEG_EVALUADOR_AGOSTO'];
											echo "<br><strong>Observaci&oacute;n:</strong><br>" . $datos['OBS_EVALUADOR_AGOSTO'] . "</p>";
										}else{
										
							?>
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal" id="<?php echo $idModal; ?>" <?php echo $deshabilitar; ?>>
											Aprobar <span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span>
										</button>
							<?php
										}
									}
								}else{echo "----";}
								echo "</small></td>";
								echo "<td class='text-center'><small>";
								if(isset($datos['ESPERADO_DICIEMBRE']) && $datos['ESPERADO_DICIEMBRE'] != 0 )
								{
									echo "<p class='bg-info'><strong>Esperado: </strong><br>" . $datos['ESPERADO_DICIEMBRE'] . "</p>";
									echo "<hr>";
									if(isset($datos['SEGUIMIENTO_DICIEMBRE']))
									{
										echo "<p class='bg-success'><strong>SEGUIMIENTO</strong>";
										echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEGUIMIENTO_DICIEMBRE'];//Cumplimiento
										echo "<br><strong>Avance:</strong><br>" . $datos['AVANCE_DICIEMBRE'] . "</p>";
										echo "<hr>";
										$idModal = $datos['ID_ASIGNAR_PILAR'] . "-DICIEMBRE";
										if($datos['APROBAR_DICIEMBRE'] == 1){//si se aprobo mostrar informacion de lo contrario mostrar informacion
											echo "<p class='bg-primary'><strong>APROBADO</strong></p>";//Aprobado
										}elseif($datos['APROBAR_DICIEMBRE'] == 2){
											echo "<p class='bg-danger'><strong>DESAPROBADO</strong>";//Desaprobado
											echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEG_EVALUADOR_DICIEMBRE'];
											echo "<br><strong>Observaci&oacute;n:</strong><br>" . $datos['OBS_EVALUADOR_DICIEMBRE'] . "</p>";
										}else{
										
							?>
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal" id="<?php echo $idModal; ?>" <?php echo $deshabilitar; ?>>
											Aprobar <span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span>
										</button>
							<?php
										}
									}
								}else{echo "----";}
								echo "</small></td>";
								echo "</tr>";
							endforeach;
						}
						else
						{
							echo "<tr >";
							echo "<td class='text-center' colspan=9>Falta asignar los compromisos para este Macroproceso</td>";
							echo "</tr>";
						}
						echo "</table>";
				endforeach;
			?>
		</div>
	</div>
</div>

<!--INICIO Modal para aprobar para el peridodo -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">	
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--INICIO Modal para aprobar para el peridodo -->