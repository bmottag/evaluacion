<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                BUSCAR SOLICITUDES DE SALAS
            </h4>
        </div>
    </div>	
	
	<div class="col-md-6">
		<div class="well">
			<div class="row">
				<div class="col-md-12">			
					<form  name="frmEstado" id="frmEstado" role="form" method="post" >
						<legend class="text-error">Buscar por fecha y sala</legend>
						<div class="row">			
							<div class="col-md-6">
								<label class="control-label">Fecha</label><br>
								<script type="text/javascript">
									$(function(){	
										$('#fechaSol').datepicker({		
											dateFormat: 'dd/mm/yy'
										});
									})
								</script>
								<input type='text' class="form-control" name='fechaSol' id='fechaSol' value='<?php echo date('d/m/y'); ?>' />
							</div>
							<div class="col-md-6">
								<label class="control-label">Sala</label><br>
								<select name="salaId" id="salaId" class="form-control" required>
									<?php 
										foreach ($salas as $data): 
											echo "<option value='" . $data['ID_SALA'] . "'>" . $data['SALA_NOMBRE'] . "</option>";
										endforeach 
									?>
								</select>
							</div>
						</div>	
						<br>
						<input type="submit" name="Button" value="Buscar" class="btn btn-primary"/>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="well">
			<div class="row">
				<div class="col-md-12">			
					<form  name="frmEstado" id="frmEstado" role="form" method="post" >
						<legend class="text-error">Buscar por ID de la solicitud</legend>
						<div class="row">
							<div class="col-md-3">
								<label class="control-label">ID</label><br>
								<input type="text" name="solicitudId" id="solicitudId" class="form-control" >
							</div>
						</div>
						<br>
						<input type="submit" name="Button" value="Buscar" class="btn btn-primary"/>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>