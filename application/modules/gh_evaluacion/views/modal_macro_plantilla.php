<script type="text/javascript" src="<?php echo base_url("js/gh_evaluacion/macroPlantilla.js"); ?>"></script> 
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">ASIGNAR MACROPROCESO
	<br><small><strong>Peso Total Programado: </strong><?php echo $peso_total[0]["PESO"];?></small>
	</h4>
</div>
<?php 
	$pesoTotal = 0;
	if($peso_total){ 
			$pesoTotal = $peso_total[0]["PESO"];
	}
	
	if($tipoGerente==1){
		$pesoMax = 200;//peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
	}else{
		$pesoMax = 100;//peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
	}
	
	$pesoPermitido = $pesoMax-$pesoTotal;
?>
<div class="modal-body">
	<form  name="formulario" id="formulario" role="form" method="post" >
		<input type="hidden" id="hddIdParam" name="hddIdParam" value="<?php echo $tipoGerente; ?>"/>
		<div class="form-group text-left">
				<label for="macroproceso" class="control-label">Macroproceso : *</label>
				<select name="macroproceso" id="macroproceso" class="form-control" required>
						<option value='' >Seleccione...</option>
						<?php for ($i = 0; $i < count($macropoceso); $i++) { 
							echo "<option value='" . $macropoceso[$i]->ID_MACROPROCESO . "'>". $macropoceso[$i]->AREA . "-" . $macropoceso[$i]->MACROPROCESO . "</option>";

						} ?>
				</select>
		</div> 
		<div class="form-group text-left">
				<label for="peso">Peso</label>
				<input type="number" name="peso" id="peso" class="form-control" placeholder="Peso" maxlength="3" min="1" max="<?php echo $pesoPermitido; ?>" required />
		</div>                    
		<div class="form-group">
			<button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary" >Aceptar</button> 
		</div>
	</form>
</div>

<div class="modal-footer" >
	<div class="table-responsive" >
		<table class="table table-responsive">
			<thead>
					<tr class="info">
					<th>Área</th>
					<th>Macroproceso</th>
					<th class='text-center'>Peso</th>
					<th class='text-center'>Eliminar</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$habilitar = "";//si solo es un macriproceso solo no se puede eliminar
				if(count($plantilla) == 1){
					$habilitar = "disabled";
				}
				foreach ($plantilla as $datos):
					echo "<tr>";
						echo "<td class='text-center'><small>" . $datos->AREA . "</small></td>";
						echo "<td class='text-left'><small>" . $datos->MACROPROCESO . "</small></td>";
						echo "<td class='text-center'><small>" . $datos->PESO_SUGERIDO . "</small></td>";
						echo "<td class='text-center'><small>";
			?>
					<center>
					<a class='btn btn-danger' href='<?php echo base_url('gh_evaluacion/admin_evaluacion/eliminarMacroPlantilla/' . $datos->ID_PLANTILLA) ?>' id="btn-delete" <?php echo $habilitar; ?>>
							<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Eliminar
					</a>
					</center>
			<?php
						echo "</small></td>";
					echo "</tr>";
				endforeach;
			?>		
			</tbody>
		</table>
	</div>	
</div>