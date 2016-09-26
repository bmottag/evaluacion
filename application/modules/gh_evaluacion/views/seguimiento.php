<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						SEGUIMIENTO MACROPROCESOS
					</h4>
				</div>
			</div>
		</div>			
	</div>
		<div class="alert alert-info" role="alert">
			<strong>Detalle </strong> del acuerdo con los compromisos a los cuales les debe realizar seguimiento.
			<br><strong>Bot&oacute;n "Cumplimiento": </strong> Permite realizar el seguimiento para el periodo indicado.
			<br><strong>Nota: </strong>
			<ul>
			<li>Verificar la informaci&oacute;n antes de guardarla, una vez ingresada al sistema no es posible cambiarla.</li>
			<li>Una vez realice el seguimiento el sistema informa al evaluador para su aprobaci&oacute;n.</li>
			</ul>
		</div>
	

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <?php echo $retornoExito ?>
    </div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
    <div class="alert alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <?php echo $retornoError ?>
    </div>
    <?php
}
?>
    
<!--INICIO DATOS DEPENDENCIA -->
    <div class="well">
        <div class="row">
            <div class="col-md-5">	
					<strong class='text-error'>DEPENDENCIA / TERRITORIAL :</strong><br />
					<?php echo $acuerdo[0]->DESCRIPCION; ?>
					<br><br><a class="btn btn-success" href=" <?php echo base_url().'gh_evaluacion/listaEvaluar/'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a>       
            </div>
            <div class="col-md-4">
                    <strong class='text-error'>ID ACUERDO: </strong><?php echo $acuerdo[0]->ID_ACUERDO; ?><br/>
                    <strong class='text-error'>Vigencia: </strong><?php echo $acuerdo[0]->VIGENCIA; ?><br/>
                    <strong class='text-error'><?php echo $usuarioEvaluador['cargo'];?>: </strong><?php echo $usuarioEvaluador['nom_usuario'] . ' ' . $usuarioEvaluador['ape_usuario'];?><br/>
                    <strong class='text-error'>Gerente P&uacute;blico: </strong><?php echo $usuarioJefe['nom_usuario'] . ' ' . $usuarioJefe['ape_usuario'];?>
            </div>
            <div class="col-md-3">
					<strong class='text-error'>Tipo Gerente Público :</strong><br />
                    <?php 
						switch ($acuerdo[0]->TIPO_GERENTE_PUBLICO) {
							case 1:
								echo "DRIRECCIONES TERRITORILES";
								break;
							case 2:
								echo "NIVEL CENTRAL";
								break;
						}
					?>
            </div>
        </div>
    </div>
<!--FIN DATOS DEPENDENCIA -->
    
    <div class="row">
        <div class="col-md-12">
            <?php
                foreach ($macro as $lista):
                        echo "<table class='table table-bordered table-striped table-hover table-condensed'>";
                        echo "<tr class='info'>";
                        echo "<td class='text-center'><strong>" . strtoupper($lista->MACROPROCESO) . "<br>Peso Asignado : </strong>" . $lista->PESO_ASIGNADO . " </td>";
                        echo "</tr>";
                        echo "</table>";
                        //lista de compromisos programados
                        $info_compromisos = $this->consultas_eval_model->get_asignacion_compromiso($lista->ID_ASIGNAR_MACRO);

                        if($info_compromisos)
                        { 
            ?>
                            <table class="table table-responsive table-bordered table-sm">
                                <thead>
                                    <tr class="info">
                                        <td class='text-center' colspan=6"><strong>CONCERTACI&Oacute;N DE COMPROMISOS</strong></td>
                                        <td class='text-center' colspan=3"><strong>SEGUIMIENTO Y EVALUACI&Oacute;N</strong></td>
                                    </tr>
                                    <tr class="active">
                                        <th class='text-center'>PILAR ESTRAT&Eacute;GICA</th>
                                        <th class='text-center'>DEFINICI&Oacute;N DEL PILAR ESTRAT&Eacute;GICA</th>
                                        <th class='text-center'>COMPROMISOS INSTITUCIONALES</th>
                                        <th class='text-center'>PESO</th>
                                        <th class='text-center'>RESTULTADO ESPERADO</th>
                                        <th class='text-center'>INDICADOR Y/O EVIDENCIA RESULTADO</th>
                                        <th class='text-center'>ABRIL</th>
                                        <th class='text-center'>AGOSTO</th>
                                        <th class='text-center'>DICIEMBRE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($info_compromisos as $datos):                            
                                            echo "<tr>";
                                            echo "<td ><small>" . $datos['PILAR'] . "</small></td>";
                                            echo "<td ><small>" . $datos['DEFINICION_PILAR'] . "</small></td>";
                                            echo "<td ><small>" . $datos['COMPROMISO'] . "</small></td>";
                                            echo "<td class='text-center'><small>" . $datos['PESO_PILAR'] . "</small></td>";
                                            echo "<td class='text-center'><small>";
                                            if($datos['RESULTADO_ESPERADO']==1){ echo "Nominal"; }else{ echo "Porcentual"; }
                                            echo "</small></td>";
                                            echo "<td ><small>" . $datos['INDICADOR'] . "</small></td>";

                                            echo "<td class='text-center'><small>";
                                            $modal = 'abril_' . $datos["ID_ASIGNAR_PILAR"];
											if(!is_null($datos['SEGUIMIENTO_ABRIL'])){//si se realizo el seguimiento no muestra el modal
												$modal = '';
											}
                                            if(isset($datos['ESPERADO_ABRIL']) && $datos['ESPERADO_ABRIL'] != 0 )
											{
                                    ?>
													<p class='bg-info'><strong>Esperado: </strong><br><?php echo $datos['ESPERADO_ABRIL']; ?></p>
													<hr>
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#<?php echo $modal; ?>" <?php if($modal == ''){echo "disabled";} ?>>
                                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cumplimiento = <span class="badge"><?php if(isset($datos['SEGUIMIENTO_ABRIL'])){echo $datos['SEGUIMIENTO_ABRIL'];}else{echo "0";}?></span>
                                                    </button>
                                                    <br><br>
													<?php if(isset($datos['SEGUIMIENTO_ABRIL'])){ ?>
													<p class='bg-success'><strong>Avance:</strong><br><?php echo $datos['AVANCE_ABRIL']; ?></p>
													<?php } ?>
                                    <?php 	}else{echo "----";} ?>
									
	<!--INICIO Modal para SEGUIMIENTO ABRIL -->
	<div class="modal fade" id="<?php echo $modal; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
		<div class="modal-dialog" role="document">					
			<div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">SEGUIMIENTO
								<br><small><strong>Compromiso : </strong><?php echo $datos['COMPROMISO'];?></small>
								<br><small><strong>Indicador: </strong><?php echo  $datos['INDICADOR'] ;?></small>
								<br><small><strong>Porcentaje esperado abril: </strong><?php echo  $datos['ESPERADO_ABRIL'] ;?></small>
						</h4>
				</div>
				<div class="modal-body">
					<form  name="formulario" role="form" method="post" action="<?php echo base_url('gh_evaluacion/guardarSeguimiento'); ?>">
						<?php 
						//peso maximo que se puede hacer seguimiento
						$pesoPermitido = $datos['ESPERADO_ABRIL'];
						?>
						<input type="hidden" id="hddIdAcuerdo" name="hddIdAcuerdo" value="<?php echo $idAcuerdo; ?>"/>
						<input type="hidden" id="hddPeriodo" name="hddPeriodo" value="ABRIL"/>
						<input type="hidden" id="hddIdAsignarPilar" name="hddIdAsignarPilar" value="<?php echo $datos["ID_ASIGNAR_PILAR"]; ?>"/>

						<div class="form-group text-left">
							<label for="peso">Porcentaje de cumplimiento ABRIL</label>
							<input type="number" name="peso" id="peso" class="form-control" placeholder="Peso" maxlength="2" min="1" max="<?php echo $pesoPermitido; ?>" required />
						</div>			

						<div class="form-group text-left">
							<label for="message-text" class="control-label">Avance cualitativo ABRIL: *</label>
							<textarea class="form-control" name="avance" id="avance" rows="2" required></textarea>
						</div>

						<div class="form-group">
							<button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary" >Aceptar</button> 
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>                       
	<!--FIN Modal SEGUIMIENTO ABRIL -->
											
									<?php 	echo "<small></td>";
                                            
                                            echo "<td class='text-center'><small>";
                                            $modal = 'agosto_' . $datos["ID_ASIGNAR_PILAR"];
											if(!is_null($datos['SEGUIMIENTO_AGOSTO'])){//si se realizo el seguimiento no muestra el modal
												$modal = '';
											}
                                            if(isset($datos['ESPERADO_AGOSTO']) && $datos['ESPERADO_AGOSTO'] != 0 )
											{
                                    ?>
													<p class='bg-info'><strong>Esperado: </strong><br><?php echo $datos['ESPERADO_AGOSTO']; ?></p>
													<hr>
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#<?php echo $modal; ?>" <?php if($modal == ''){echo "disabled";} ?>>
                                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cumplimiento = <span class="badge"><?php if(isset($datos['SEGUIMIENTO_AGOSTO'])){echo $datos['SEGUIMIENTO_AGOSTO'];}else{echo "0";}?></span>
                                                    </button> 
                                                    <br><br>
													<?php if(isset($datos['SEGUIMIENTO_AGOSTO'])){ ?>
													<p class='bg-success'><strong>Avance:</strong><br><?php echo $datos['AVANCE_AGOSTO']; ?></p>
													<?php } ?>
                                    <?php 	}else{echo "----";}  ?>

	<!--INICIO Modal para SEGUIMIENTO AGOSTO -->
	<div class="modal fade" id="<?php echo $modal; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
		<div class="modal-dialog" role="document">					
			<div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">SEGUIMIENTO
								<br><small><strong>Compromiso : </strong><?php echo $datos['COMPROMISO'];?></small>
								<br><small><strong>Indicador: </strong><?php echo  $datos['INDICADOR'] ;?></small>
								<br><small><strong>Porcentaje esperado agosto: </strong><?php echo  $datos['ESPERADO_AGOSTO'] ;?></small>
						</h4>
				</div>
				<div class="modal-body">
					<form  name="formulario" role="form" method="post" action="<?php echo base_url('gh_evaluacion/guardarSeguimiento'); ?>">
						<?php 
						//peso maximo que se puede hacer seguimiento
						$pesoPermitido = $datos['ESPERADO_AGOSTO'];
						?>
						<input type="hidden" id="hddIdAcuerdo" name="hddIdAcuerdo" value="<?php echo $idAcuerdo; ?>"/>
						<input type="hidden" id="hddPeriodo" name="hddPeriodo" value="AGOSTO"/>
						<input type="hidden" id="hddIdAsignarPilar" name="hddIdAsignarPilar" value="<?php echo $datos["ID_ASIGNAR_PILAR"]; ?>"/>

						<div class="form-group text-left">
							<label for="peso">Porcentaje de cumplimiento AGOSTO</label>
							<input type="number" name="peso" id="peso" class="form-control" placeholder="Peso" maxlength="2" min="1" max="<?php echo $pesoPermitido; ?>" required />
						</div>			

						<div class="form-group text-left">
							<label for="message-text" class="control-label">Avance cualitativo AGOSTO: *</label>
							<textarea class="form-control" name="avance" id="avance" rows="2" required></textarea>
						</div>

						<div class="form-group">
							<button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary" >Aceptar</button> 
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>                       
	<!--FIN Modal SEGUIMIENTO AGOSTO -->
									
									<?php	echo "</small></td>";
                                            
                                            echo "<td class='text-center'><small>";
                                            $modal = 'diciembre_' . $datos["ID_ASIGNAR_PILAR"];
											if(!is_null($datos['SEGUIMIENTO_DICIEMBRE'])){//si se realizo el seguimiento no muestra el modal
												$modal = '';
											}
                                            if(isset($datos['ESPERADO_DICIEMBRE']) && $datos['ESPERADO_DICIEMBRE'] != 0 )
											{
                                    ?>
													<p class='bg-info'><strong>Esperado: </strong><br><?php echo $datos['ESPERADO_DICIEMBRE']; ?></p>
													<hr>
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#<?php echo $modal; ?>" <?php if($modal == ''){echo "disabled";} ?>>
                                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cumplimiento = <span class="badge"><?php if(isset($datos['SEGUIMIENTO_DICIEMBRE'])){echo $datos['SEGUIMIENTO_DICIEMBRE'];}else{echo "0";}?></span>
                                                    </button>
                                                    <br><br>
													<?php if(isset($datos['SEGUIMIENTO_DICIEMBRE'])){ ?>
													<p class='bg-success'><strong>Avance:</strong><br><?php echo $datos['AVANCE_DICIEMBRE']; ?></p>
													<?php } ?>
                                    <?php 	}else{echo "----";} ?>
									
	<!--INICIO Modal para SEGUIMIENTO DICIEMBRE -->
	<div class="modal fade" id="<?php echo $modal; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
		<div class="modal-dialog" role="document">					
			<div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">SEGUIMIENTO
								<br><small><strong>Compromiso : </strong><?php echo $datos['COMPROMISO'];?></small>
								<br><small><strong>Indicador: </strong><?php echo  $datos['INDICADOR'] ;?></small>
								<br><small><strong>Porcentaje esperado diciembre: </strong><?php echo  $datos['ESPERADO_DICIEMBRE'] ;?></small>
						</h4>
				</div>
				<div class="modal-body">
					<form  name="formulario" role="form" method="post" action="<?php echo base_url('gh_evaluacion/guardarSeguimiento'); ?>">
						<?php 
						//peso maximo que se puede hacer seguimiento
						$pesoPermitido = $datos['ESPERADO_DICIEMBRE'];
						?>
						<input type="hidden" id="hddIdAcuerdo" name="hddIdAcuerdo" value="<?php echo $idAcuerdo; ?>"/>
						<input type="hidden" id="hddPeriodo" name="hddPeriodo" value="DICIEMBRE"/>
						<input type="hidden" id="hddIdAsignarPilar" name="hddIdAsignarPilar" value="<?php echo $datos["ID_ASIGNAR_PILAR"]; ?>"/>

						<div class="form-group text-left">
							<label for="peso">Porcentaje de cumplimiento DICIEMBRE</label>
							<input type="number" name="peso" id="peso" class="form-control" placeholder="Peso" maxlength="2" min="1" max="<?php echo $pesoPermitido; ?>" required />
						</div>			

						<div class="form-group text-left">
							<label for="message-text" class="control-label">Avance cualitativo DICIEMBRE: *</label>
							<textarea class="form-control" name="avance" id="avance" rows="2" required></textarea>
						</div>

						<div class="form-group">
							<button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary" >Aceptar</button> 
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>                       
	<!--FIN Modal SEGUIMIENTO DICIEMBRE -->
									
									<?php 	echo "</small></td>";
                                            echo "</tr>";
                                        endforeach;
                                    ?>
                                </tbody>
                            </table>
            <?php   
                        }
                endforeach;
            ?>
        </div>
    </div>
</div>