<?php 
    if($user["POLITICA"] != 1) {
?> 	
    <div class='alert alert-danger text-center'><strong>Atenci&oacute;n: </strong>Para diligenciar este formulario, debes aceptar el "Aviso de privacidad para la recolecci&oacute;n de datos personales" ubicado en el formulario "Datos Usuario".</div>
<?php } else { ?>
<script type="text/javascript" src="<?php echo base_url("js/usuarios/dependiente.js"); ?>"></script>
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
					DEPENDIENTES
				</h4>
			</div>
		</div>
	
	<div class="well">
            <h3><strong>Registrar las personas que dependen de usted</strong></h3><br>
		<form  name="formulario" id="formulario" role="form" method="post" >
			<input type="hidden" id="hddIDDependiente" name="hddIDDependiente" value="<?php echo $infoDependiente?$infoDependiente[0]["ID_DEPENDIENTE"]:""; ?>"/>
  			<div class="row">
	  			<div class="form-group col-md-2">
                                        <label for="parentesco">Parentesco : *</label>
					<select name="parentesco" id="parentesco" class="form-control" autocomplete="off">
						<option value='' >Seleccione...</option>
						<option value=1 <?php if(1==$infoDependiente[0]["PARENTESCO"]){?>selected="selected"<?php }?> >Conyuge</option>
						<option value=2 <?php if(2==$infoDependiente[0]["PARENTESCO"]){?>selected="selected"<?php }?> >Hijo</option>
						<option value=3 <?php if(3==$infoDependiente[0]["PARENTESCO"]){?>selected="selected"<?php }?> >Hermano</option>
						<option value=4 <?php if(4==$infoDependiente[0]["PARENTESCO"]){?>selected="selected"<?php }?> >Madre</option>
						<option value=5 <?php if(5==$infoDependiente[0]["PARENTESCO"]){?>selected="selected"<?php }?> >Padre</option>
                                                <option value=6 <?php if(6==$infoDependiente[0]["PARENTESCO"]){?>selected="selected"<?php }?> >Nieto</option>
						<?php						
							//si existen datos en dependiente se deshabilita la opcion ninguno
							if(!$dependientes)
							{
						?>		
								<option value=99 <?php if(99==$infoDependiente[0]["PARENTESCO"]){?>selected="selected"<?php }?> >Ninguno</option>
						<?php } ?>
						
					</select>
				</div>
	  			<div class="form-group col-md-4">
	    			<label for="txtNombres">Nombres : *</label>
	    			<input type="text" id="txtNombres" name="txtNombres" value="<?php echo $infoDependiente?$infoDependiente[0]["NOM_DEPENDIENTE"]:""; ?>" class="form-control" placeholder="Nombres" >
				</div>
	  			<div class="form-group col-md-4">
	    			<label for="txtApellidos">Apellidos : *</label>
	    			<input type="text" id="txtApellidos" name="txtApellidos" value="<?php echo $infoDependiente?$infoDependiente[0]["APE_DEPENDIENTE"]:""; ?>" class="form-control" placeholder="Apellidos" >
	  			</div>
				<div class="col-md-2">
					<label for="sexo">Sexo : *</label>
					<select name="sexo" id="sexo" class="form-control" autocomplete="off" >
							<option value='' >...</option>
							<option value='F' <?php if('F'==$infoDependiente[0]["SEXO"]){?>selected="selected"<?php }?> >Femenino</option>
							<option value='M' <?php if('M'==$infoDependiente[0]["SEXO"]){?>selected="selected"<?php }?> >Masculino</option>					
					</select>
				</div>				
  			</div>
			<?php 
				$mostrar =  'style="display: none;"';
				if(99!=$infoDependiente[0]["PARENTESCO"]){ 
					  $mostrar =  '';
				}  
			?>
			<div id="mostrar" <?php echo $mostrar; ?>>
			<div class="row" >
				<div class="col-md-3">
					<label for="tipoDocumento">Tipo de Documento : *</label>
					<select name="tipoDocumento" id="tipoDocumento" class="form-control" required autocomplete="off" >
						<option value='' >Seleccione...</option>
						<option value='CC' <?php if('CC'==$infoDependiente[0]["TIPO_DOCUMENTO"]){?>selected="selected"<?php }?> >C&eacute;dula de ciudadadan&iacute;a</option>
                                                <option value='CE' <?php if('CE'==$infoDependiente[0]["TIPO_DOCUMENTO"]){?>selected="selected"<?php }?> >C&eacute;dula de extranjer&iacute;a </option>
						<option value='RC' <?php if('RC'==$infoDependiente[0]["TIPO_DOCUMENTO"]){?>selected="selected"<?php }?> >Registro civil</option>
						<option value='TI' <?php if('TI'==$infoDependiente[0]["TIPO_DOCUMENTO"]){?>selected="selected"<?php }?> >Tarjeta de identidad</option>
					</select>
				</div>
	  			<div class="form-group col-md-3">
	    			<label for="txtIdentificacion">Nro. Identificaci&oacute;n : *</label>
	    			<input type="text" id="txtIdentificacion" name="txtIdentificacion" value="<?php echo $infoDependiente?$infoDependiente[0]["NUM_IDENT_DEP"]:""; ?>" class="form-control" placeholder="N&uacute;mero de C&eacute;dula" required >
				</div>
	  			<div class="form-group col-md-3">
	    			<label for="txtLugar">Lugar de Expedic&oacute;n : *</label>
	    			<input type="text" id="txtLugar" name="txtLugar" value="<?php echo $infoDependiente?$infoDependiente[0]["LUGAR_EXPEDICION"]:""; ?>" class="form-control" placeholder="Lugar de Expedic&oacute;n" required >
	  			</div>
				<div class="form-group col-md-3">
					<script type="text/javascript">
						$(function(){	
							$('#fechaNacimiento').datepicker({		
								dateFormat: 'dd/mm/yy'
							});
						})
					</script>				
					<label for="fechaNacimiento">Fecha de Nacimiento : *</label>
					<input type='text' id='fechaNacimiento' name='fechaNacimiento' value="<?php echo $infoDependiente ? $infoDependiente[0]["FECHA_NACIMIENTO"]:""; ?>" size='10' class="form-control" placeholder="Fecha de Nacimiento" required />
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label for="subsidio">Derecho a subsidio : *</label>
					<select name="subsidio" id="subsidio" class="form-control" required >
						<option value='' >...</option>
						<option value='S' <?php if('S'==$infoDependiente[0]["SUBSIDIO"]){?>selected="selected"<?php }?>	>Si</option>
						<option value='N' <?php if('N'==$infoDependiente[0]["SUBSIDIO"]){?>selected="selected"<?php }?>	>No</option>					
					</select>
				</div>
	  			<div class="form-group col-md-2">
	    			<label for="razonSocial">Raz&oacute;n Subsidio : *</label>
					<select name="razonSocial" id="razonSocial" class="form-control" required >
						<option value='' >...</option>
						<option value='D' <?php if('D'==$infoDependiente[0]["RAZON_SUBSIDIO"]){?>selected="selected"<?php }?> >Discapacidad</option>
						<option value='M' <?php if('M'==$infoDependiente[0]["RAZON_SUBSIDIO"]){?>selected="selected"<?php }?> >Menor de edad</option>
						<option value='P' <?php if('P'==$infoDependiente[0]["RAZON_SUBSIDIO"]){?>selected="selected"<?php }?> >Padre</option>
						<option value='N' <?php if('N'==$infoDependiente[0]["RAZON_SUBSIDIO"]){?>selected="selected"<?php }?> >Ninguna</option>
					</select>
				</div>
			</div>
			</div>

			<div class="alert alert-info">
                            <h5 style="text-align: center;">Una vez diligenciada la información, podras continuar con el formulario de "Actividades".
                            </h5>
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
					
					<?php if($btnGuardarDep == 'SI') {
                                            echo "<input type='button' id='btnGuardar' name='btnGuardar' value='Guardar Datos' class='btn btn-primary'/>";
                                        } else if($btnGuardarDep == 'NO') {
                                            echo "<div class='alert alert-warning'><strong>Atenci&oacute;n : </strong>No puede ingresar mas datos porque registro la opci&oacute;n ninguno.</div>";
                                        }
                                        ?>
				</div>
			</div>	
		</form>
	</div>
    <div id="resultado"></div><!-- Carga lista -->
</div>
<?php } ?>
