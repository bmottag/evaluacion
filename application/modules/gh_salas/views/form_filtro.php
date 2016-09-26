<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                GENERAR REPORTE PARA UN PERIODO DE TIEMPO
            </h4>
        </div>
    </div>	
	
	<div class="well">
		<div class="row" align="center">
			<div style="width:50%;" align="center">
					<form  name="frmEstado" id="frmEstado" role="form" method="post" action="<?php echo site_url("/gh_salas/admin_salas/generar_xls"); ?>">
						<legend class="text-error">Seleccionar fechas</legend>
						<div class="row">
							<div class="col-md-3">
								<label class="control-label">Desde</label><br>
								<script type="text/javascript">
									$(function(){	
										$('#fechaIni').datepicker({		
											dateFormat: 'dd/mm/yy'
										});
									})
								</script>
								<input type='text' class="form-control" name='fechaIni' id='fechaIni' value='<?php echo date('d/m/y'); ?>' />
							</div>
							<div class="col-md-3">
								<label class="control-label">Hasta</label><br>
								<script type="text/javascript">
									$(function(){	
										$('#fechaFin').datepicker({		
											dateFormat: 'dd/mm/yy'
										});
									})
								</script>
								<input type='text' class="form-control" name='fechaFin' id='fechaFin' value='<?php echo date('d/m/y'); ?>' />
							</div>							
						</div>
						<br>
						<input type="submit" name="Button" value="Buscar" class="btn btn-primary"/>
					</form>	
			</div>
		</div>	
	</div>
</div>