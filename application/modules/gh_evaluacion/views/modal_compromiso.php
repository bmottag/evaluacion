<script type="text/javascript" src="<?php echo base_url("js/gh_evaluacion/asignarCompromiso.js"); ?>"></script> 
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">ASIGNAR COMPROMISO	
	<br><small><strong>Macroproceso : </strong><?php echo $macro[0]->MACROPROCESO;?></small>
	<br><small><strong>Peso Macroproceso: </strong><?php echo $macro[0]->PESO_ASIGNADO;?></small>
	<br><small><strong>Peso Programado: </strong><?php echo $macro[0]->PESO_PROGRAMADO;?></small>	
	</h4>
</div>
<?php 
//peso maximo que se puede asignar al compromiso
$pesoPermitido = $macro[0]->PESO_ASIGNADO - $macro[0]->PESO_PROGRAMADO;
?>
<div class="modal-body">
	<form  name="formulario" id="formulario" role="form" method="post" >
		<input type="hidden" id="hddIdAcuerdo" name="hddIdAcuerdo" value="<?php echo $macro[0]->FK_ID_ACUERDO; ?>"/>
		<input type="hidden" id="hddIdMacro" name="hddIdMacro" value="<?php echo $macro[0]->ID_ASIGNAR_MACRO; ?>"/>										
		<input type="hidden" id="hddPesoProgramado" name="hddPesoProgramado" value="<?php echo $macro[0]->PESO_PROGRAMADO; ?>"/>
		<input type="hidden" id="hddPesoPermitido" name="hddPesoPermitido" value="<?php echo $pesoPermitido; ?>"/>
		<div class="row">
			<div class="col-md-5">
				<div class="form-group text-left">
						<label for="pilar" class="control-label">Pilar Estrat&eacute;gico : *</label>
						<select name="pilar" id="pilar" class="form-control" required>
								<option value='' >Seleccione...</option>
								<?php for ($i = 0; $i < count($pilar); $i++) { 
									echo "<option value='" . $pilar[$i]->ID_PILAR . "'>" . $pilar[$i]->PILAR . "</option>";
								} ?>
						</select>            
				</div>			
			</div>
			<div class="col-md-3">
				<div class="form-group text-left">
						<label for="peso">Peso</label>
						<input type="number" name="peso" id="peso" class="form-control" placeholder="Peso" maxlength="2" min="1" max="<?php echo $pesoPermitido; ?>" required />
				</div>			
			</div>
			<div class="col-md-4">
				<div class="form-group text-left">
						<label for="resultado" class="control-label">Resultado Esperado - Unidad : *</label>
						<select name="resultado" id="resultado" class="form-control" required>
								<option value='' >Seleccione...</option>
								<option value=1 >Nominal</option>
								<option value=2 >Porcentual</option>														
						</select>            
				</div>			
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group text-left">
						<label for="message-text" class="control-label">Compromisos institucionales : *</label>
						<textarea class="form-control" name="compromisos" id="compromisos" rows="2" required></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group text-left">
						<label for="message-text" class="control-label">Indicador y/o evidencia resultado : *</label>
						<textarea class="form-control" name="indicador" id="indicador" required></textarea>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group text-left">
						<label for="peso">Seguimiento esperado abril</label>
						<input type="number" name="abril" id="abril" class="form-control periodos" placeholder="Peso" maxlength="2" min="1" max="<?php echo $pesoPermitido; ?>" />
				</div>			
			</div>
			<div class="col-md-4">
				<div class="form-group text-left">
						<label for="peso">Seguimiento esperado agosto</label>
						<input type="number" name="agosto" id="agosto" class="form-control periodos" placeholder="Peso" maxlength="2" min="1" max="<?php echo $pesoPermitido; ?>" />
				</div>			
			</div>
			<div class="col-md-4">
				<div class="form-group text-left">
						<label for="peso">Seguimiento esperado diciembre</label>
						<input type="number" name="diciembre" id="diciembre" class="form-control periodos" placeholder="Peso" maxlength="2" min="1" max="<?php echo $pesoPermitido; ?>" />
				</div>			
			</div>
		</div>
		<div class="form-group">
			<button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary" >Aceptar</button> 
		</div>
	</form>
</div>

<?php if($compromisos){ ?>
<div class="modal-footer" >
	<div class="table-responsive" >
		<table class="table table-responsive">
			<thead>
				<tr class="info">
					<th>Pilar estrat&eacute;gico </th>
					<th>Peso</th>
					<th>Compromiso</th>
					<th>Resutado esperado</th>
					<th>Indicador</th>
					<th>Eliminar</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($compromisos as $datos):
					echo "<tr>";
						echo "<td class='text-left'><small>" . $datos['PILAR'] . "</small></td>";
						echo "<td class='text-center'><small>" . $datos['PESO_PILAR'] . "</small></td>";
						echo "<td class='text-left'><small>" . $datos['COMPROMISO'] . "</small></td>";
						echo "<td class='text-center'><small>";
						if($datos['RESULTADO_ESPERADO']==1){ echo "Nominal"; }else{ echo "Porcentual"; }
						echo "</small></td>";
						echo "<td class='text-left'><small>" . $datos['INDICADOR'] . "</small></td>";
						echo "<td class='text-center'><small>";
			?>
						<a class='btn btn-danger' href='<?php echo base_url('gh_evaluacion/eliminarCompromiso/' . $datos['ID_ASIGNAR_PILAR']) ?>' id="btn-delete">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Eliminar
						</a>
			<?php
						echo "</small></td>";
					echo "</tr>";
				endforeach;
			?>		
			</tbody>
		</table>
	</div>	
</div>
<?php } ?>