<script type="text/javascript" src="<?php echo base_url("js/gh_evaluacion/aprobarSeguimiento.js"); ?>"></script> 
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">APROBAR SEGUIMIENTO DE <?php echo $periodo; ?>
	<br><small><strong>Compromiso : </strong><?php echo $info_compromisos['COMPROMISO'];?></small>
	<br><small><strong>Indicador: </strong><?php echo  $info_compromisos['INDICADOR'] ;?></small>
	<br><small><strong>Porcentaje esperado : </strong><?php echo $info_compromisos["ESPERADO_" . $periodo]; ?></small>
	<br><small><strong>Cumplimento : </strong><?php echo $info_compromisos["SEGUIMIENTO_" . $periodo]; ?></small>
	<br><small><strong>Avance cualitativo : </strong><?php echo $info_compromisos["AVANCE_" . $periodo]; ?></small>	
	</h4>
</div>
<?php 
//peso maximo que se puede hacer seguimiento
$pesoPermitido = $info_compromisos["ESPERADO_" . $periodo];
?>
<div class="modal-body">
	<form  name="formulario" id="formulario" role="form" method="post">
		<input type="hidden" id="hddIdAcuerdo" name="hddIdAcuerdo" value="<?php echo $info_compromisos["FK_ID_ACUERDO"]; ?>"/>
		<input type="hidden" id="hddPeriodo" name="hddPeriodo" value="<?php echo $periodo; ?>"/>
		<input type="hidden" id="hddIdAsignarPilar" name="hddIdAsignarPilar" value="<?php echo $info_compromisos["ID_ASIGNAR_PILAR"]; ?>"/>

		<div class="form-group text-left">
			<label for="aprobar">Aprobar seguimiento : </label>
			<select name="aprobar" id="aprobar" class="form-control" required>
				<option value='' >Seleccione...</option>
				<option value=1>Si</option>
				<option value=2>No</option>					
			</select>
		</div>
		
		<div class="form-group text-left" id="porcentaje" style="display: none">
			<label for="peso">Porcentaje de cumplimiento : </label>
			<input type="number" name="peso" id="peso" class="form-control" placeholder="Peso" maxlength="2" min="1" max="<?php echo $pesoPermitido; ?>" />
		</div>			

		<div class="form-group text-left" id="observ" style="display: none">
			<label for="message-text" class="control-label">Observaci&oacute;n : </label>
			<textarea class="form-control" name="observacion" id="observacion" rows="2" ></textarea>
		</div>

		<div class="form-group">
			<button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary" >Aceptar</button> 
		</div>
	</form>
</div>