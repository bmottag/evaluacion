<div class="container">
	<p>    
		<a href="<?php echo base_url("/usuarios/datos/1"); ?>" class="btn btn-info" role="button">Datos Usuario</a>
		<a href="<?php echo base_url("/usuarios/academica"); ?>" class="btn btn-info" role="button">Informaci&oacute;n Acad&eacute;mica</a>
		<a href="<?php echo base_url("/usuarios/idiomas"); ?>" class="btn btn-info" role="button">Idiomas</a>
		<a href="<?php echo base_url("/usuarios/dependientes"); ?>" class="btn btn-info" role="button">Dependientes</a>
		<a href="<?php echo base_url("/usuarios/actividades"); ?>" class="btn btn-info" role="button">Actividades</a>
		<a href="<?php echo base_url("/usuarios/mascotas"); ?>" class="btn btn-info" role="button">Mascotas</a>
		<a href="<?php echo base_url("/usuarios/contacto"); ?>" class="btn btn-info" role="button">Contacto para emergencia</a>
	</p>
	<!-------- Barra de progreso -------->
	<div class="row" align="center">
		<div style="width:50%;" align="center">
				<div class="progress progress-striped active">
						<div class="progress-bar <?php echo $colorProgreso; ?>" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progreso; ?>%">
								<span > <?php echo round($progreso); ?>% completado</span>
						</div>
				</div>
		</div>
	</div>		
	<!-------- Barra de progreso -------->
</div>