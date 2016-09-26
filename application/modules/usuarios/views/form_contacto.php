<?php 
    if($user["POLITICA"] != 1) {
?> 	
    <div class='alert alert-danger text-center'><strong>Atenci&oacute;n: </strong>Para diligenciar este formulario, debes aceptar el "Aviso de privacidad para la recolecci&oacute;n de datos personales" ubicado en el formulario "Datos Usuario".</div>
<?php } else { ?>
<script type="text/javascript" src="<?php echo base_url("js/usuarios/contacto.js"); ?>"></script>
<div class="container">

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

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="list-group-item-heading">
					CONTACTO PARA EMERGENCIA
				</h4>
			</div>
		</div>	
	<div class="well">
		<form  name="formContacto" id="formContacto" role="form" method="post" >
			<input type="hidden" id="hddIDContacto" name="hddIDContacto" value="<?php echo (isset($contacto["ID_CONTACTO"]))?$contacto["ID_CONTACTO"]:""; ?>"/>
  			<div class="row">
	  			<div class="form-group col-md-5">
	    			<label for="txtNombres">Nombre </label>
	    			<input type="text" id="txtNombres" name="txtNombres" value="<?php echo (isset($contacto["NOMBRE_CONTACTO"]))?$contacto["NOMBRE_CONTACTO"]:""; ?>" maxlength="100" class="form-control" placeholder="Nombre contacto" autofocus >
				</div>
	  			<div class="form-group col-md-4">
	    			<label for="txtParentesco">Parentesco</label>
	    			<input type="text" id="txtParentesco" name="txtParentesco" value="<?php echo (isset($contacto["PARENTESCO"]))?$contacto["PARENTESCO"]:""; ?>" maxlength="20" class="form-control" placeholder="Parentesco contacto"  >
	  			</div>
				<div class="form-group col-md-3">
					<label for="txtCelular">N&uacute;mero de Celular</label>
					<input type="text" id="txtCelular" name="txtCelular" value="<?php echo (isset($contacto["CELULAR_CONTACTO"]))?$contacto["CELULAR_CONTACTO"]:""; ?>" maxlength="10" class="form-control" placeholder="N&uacute;mero celular" >
				</div>			
  			</div>
                        <br>
                        
                        <div class="alert alert-info">
                            <h5 style="text-align: center;">Verifica que hayas diligenciado todos los formularios.
                            </h5>
                        </div>
                        
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
					<input type="button" id="btnContacto" name="btnContacto" value="Guardar Datos" class="btn btn-primary"/>
				</div>
			</div>	
		</form>
	</div>
</div>
<?php } ?>