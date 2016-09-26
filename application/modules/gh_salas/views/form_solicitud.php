<script type="text/javascript" src="<?php echo base_url("js/gh_salas/gh_salas.js"); ?>"></script>	
<script type="text/javascript">
function valida(form) {
	var ok = true;

	for (var i=0; i<form.length; i++) {
		if(form[i].type =='text') {
		form.fecha.value = form[i].value;
			if (form[i].value == null || form[i].value.length == 0 || /^\s*$/.test(form[i].value)){
				ok = false;
			}
		}
	}
  
	if(ok == false)
		alert('Debe indicar la fecha de la solicitud');
	return ok;
}
</script>
		
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                SOLICITUD DE SALAS
            </h4>
        </div>
    </div>
<?php if($solicitudes){ ?>	

	<table class="table table-bordered table-striped table-hover table-condensed">
		<tr class="info">
			<td colspan="7"><h5 align="center">Horario reservado: <?php echo $this->input->post('nombreSala') . ' / ' .  $this->input->post('fecha');?></h5></td>
		</tr>	
		<tr class="info">
			<td ><p class="text-center"><strong>No. registro</strong></p></td>
			<td ><p class="text-center"><strong>Hora</strong></p></td>
			<td ><p class="text-center"><strong>T&iacute;tulo</strong></p></td>
			<td ><p class="text-center"><strong>Responsable</strong></p></td>
			<td ><p class="text-center"><strong>Extensi&oacute;n</strong></p></td>
			<td ><p class="text-center"><strong>Estado</strong></p></td>
			<td ><p class="text-center"><strong>Duplicar</strong></p></td>
		</tr>
		<?php 
		foreach ($solicitudes as $data):
			echo "<tr>";
			echo "<td>" . $data['ID_SOLICITUD_SALA'] . "</td>";
			echo "<td>" . $data['HORA_INICIO'] . " -  " . $data['HORA_FINAL'] . "</td>";
			echo "<td>" . $data['TITULO_EVENTO'] . "</td>";
			echo "<td>" . strtoupper($data['NOM_USUARIO']) . ' ' . strtoupper($data['APE_USUARIO']) . "</td>";
			echo "<td class='text-center'>" . $data['EXT_USUARIO'] . "</td>";
			echo "<td class='text-center'><span class='label " . $data["CLASE"]. "'>".$data['ESTADO']."</span></td>";
			echo "<td class='text-center'>";
			$nameFecha = 'fechaDup' . $data['ID_SOLICITUD_SALA'];
			$solicitudID = $data['ID_SOLICITUD_SALA'];
		?>
			<script type="text/javascript">
				$(function(){	
					$('#<?php echo $nameFecha ?>').datepicker({		
						dateFormat: 'dd/mm/yy'
					});
				})
			</script>
			<form  name="<?php echo $solicitudID ?>" id="<?php echo $solicitudID ?>" method="post" onsubmit="return valida(this)">			
			<input type='hidden' name='solicitudId' value='<?php echo $solicitudID; ?>' />
			<input type="hidden" name="salaId" value="<?php echo $data['ID_SALA']; ?>" />
			<input type="hidden" name="nombreSala" value="<?php echo $data['SALA_NOMBRE']; ?>" />			
			<input type="hidden" id="fecha" name="fecha">
			<input type='text' name='<?php echo $nameFecha ?>' id='<?php echo $nameFecha ?>' size='10'/>&nbsp;
			<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></button>
			</form> 				
			</td>			
			</tr>
		<?php endforeach ?>
	</table>
<?php }  ?>	

	<div class="well">
		<form  name="formSala" id="formSala" role="form" method="post" >
		<input type="hidden" id="salaId" name="salaId" value="<?php echo $this->input->post('salaId'); ?>" class="form-control">
		<input type="hidden" id="nombreSala" name="nombreSala" value="<?php echo $this->input->post('nombreSala'); ?>" class="form-control">

		
  			<div class="row">
	  			<div class="form-group col-md-2">
	    			<label class="control-label">Sala</label><br>
	    			<?php echo $this->input->post('nombreSala'); ?>
				</div>
	  			<div class="form-group col-md-6">
	    			<label class="control-label">Funcionario </label><br>
	    			<?php echo $fullName; ?>
				</div>
				<div class="col-md-2">
					<label class="control-label">Fecha</label><br>
					<?php echo $this->input->post('fecha'); ?>
					<input type="hidden" id="fecha" name="fecha" value="<?php echo $this->input->post('fecha'); ?>">
				</div>				
  			</div>		
			<div class="row">
	  			<div class="form-group col-md-2">
	    			<label class="control-label">No. de personas : *</label>
	    			<input type="text" id="NroPersonas" name="NroPersonas" <?php if(isset($solicitud)) echo 'value="' . $solicitud[0]['NRO_PERSONAS'] . '"';?> class="form-control" >
				</div>
				<div class="col-md-5">
				<div class="row">
					<div class="col-md-6 text-right"><br>
						<label class="control-label">Hora Incio : *</label>
					</div>
					<?php 
					if(isset($solicitud)){
						$horaIni = $solicitud[0]['HORA_INICIO'];
						$inicio = explode(":", $horaIni);
					}
					?>
					<div class="col-md-3">
						Hora
						<select name="hora1" id="hora1" class="form-control" onChange="copiar_valor('hora1', 'minutos1','horaIni');">
							<option value='' ></option>
							<?php 
							for ($i = 8; $i <= 16; $i++) { 
								switch ($i) {
									case 8:
										$hora='08';
										break;
									case 9:
										$hora='09';
										break;
									default:
										$hora=$i;
								}			
							?>
								<option value='<?php echo $hora;?>' <?php if(isset($solicitud) && $hora==$inicio[0]){?>selected="selected"<?php }?>><?php echo $hora;?></option>
							<?php } ?>									
						</select>
					</div>
					<div class="col-md-3">
						Minutos
						<select name="minutos1" id="minutos1" class="form-control" onChange="copiar_valor('hora1', 'minutos1','horaIni');">
							<option value='00' <?php if($solicitud && '00'==$inicio[1]){?>selected="selected"<?php }?>>00</option>
							<option value='30' <?php if($solicitud && '30'==$inicio[1]){?>selected="selected"<?php }?>>30</option>
						</select>
					</div>
						<input id="horaIni" name="horaIni" type="hidden" <?php if(isset($solicitud)) echo 'value="' . $horaIni . '"';?>>
				</div>
				</div>
				<div class="col-md-5">
				<div class="row">
					<div class="col-md-6 text-right"><br>
						<label class="control-label">Hora final: *</label>
					</div>
					<?php 
					if(isset($solicitud)){
						$horaFin = $solicitud[0]['HORA_FINAL'];
						$final = explode(":", $horaFin);
					}
					?>					
					<div class="col-md-3">
						Hora
						<select name="hora2" id="hora2" class="form-control" onChange="copiar_valor('hora2', 'minutos2','horaFin');">
							<option value='' ></option>
							<?php 
							for ($i = 8; $i <= 17; $i++) { 
								switch ($i) {
									case 8:
										$hora='08';
										break;
									case 9:
										$hora='09';
										break;
									default:
										$hora=$i;
								}			
							?>
								<option value='<?php echo $hora;?>' <?php if(isset($solicitud) && $hora==$final[0]){?>selected="selected"<?php }?>><?php echo $hora;?></option>
							<?php } ?>									
						</select>
					</div>
					<div class="col-md-3">
						Minutos
						<select name="minutos2" id="minutos2" class="form-control" onChange="copiar_valor('hora2', 'minutos2','horaFin');">
							<option value='00' <?php if($solicitud && $final[1]=='00'){?>selected="selected"<?php }?>>00</option>
							<option value='30' <?php if($solicitud && $final[1]=='30'){?>selected="selected"<?php }?>>30</option>
						</select>
					</div>
						<input id="horaFin" name="horaFin" type="hidden" <?php if(isset($solicitud)) echo 'value="' . $horaFin . '"';?>>
				</div>	
				</div>
			</div>
			<div class="row">
	  			<div class="form-group col-md-4">
	    			<label class="control-label">T&iacute;tulo del Evento : *</label>
	    			<input type="text" id="titulo" name="titulo" <?php if(isset($solicitud)) echo 'value="' . $solicitud[0]['TITULO_EVENTO'] . '"';?> class="form-control" >
				</div>
				<div class="col-lg-8">
					<label class="control-label">Descripci&oacute;n del evento : *</label>
					<textarea class="form-control" name="descripcion" id="descripcion"  rows="2"><?php
					if(isset($solicitud))
						echo $solicitud[0]['DESCRIPCION'];
					?></textarea>
				</div>
			</div>
<br>
			<div class="row" align="center">
				<div style="width:50%;" align="center">
					<div id="div_cargando" style="display:none">		
						<div class="progress progress-striped active">
							<div class="progress-bar" role="progressbar"
								aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"
								style="width: 45%">
								<span class="sr-only">45% completado</span>
							</div>
						</div>
					</div>	
					<div id="div_guardado" style="display:none">			
						<div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>
					</div>	
					<div id="div_error" style="display:none">			
						<div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
					</div>	
					<input type="button" id="btnSolicitud" name="btnSolicitud" value="Enviar solicitud" class="btn btn-primary"/>
				</div>
			</div>	
		</form>
	</div>

</div>