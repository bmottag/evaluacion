<?php
    if($user["POLITICA"] != 1) {
?> 	
    <div class='alert alert-danger text-center'><strong>Atenci&oacute;n: </strong>Para diligenciar este formulario, debes aceptar el "Aviso de privacidad para la recolecci&oacute;n de datos personales" ubicado en el formulario "Datos Usuario".</div>
<?php } else { ?>
<script type="text/javascript" src="<?php echo base_url("js/usuarios/mascotas.js"); ?>"></script>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                MASCOTAS
            </h4>
        </div>
    </div>	
    <div class="well">
        <h3><strong>Registrar sus mascotas</strong></h3><br>
        <form  name="formMascotas" id="formMascotas" role="form" method="post" >
            <input type="hidden" id="hddIDActividad" name="hddIDMascota" value="<?php echo $infoMascota ? $infoMascota[0]["ID_MASCOTA"] : ""; ?>"/>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="mascota">Mascota : *</label>

                    <select name="mascota" id="mascota" class="form-control" autocomplete="off">
                        <option value='' >Seleccione...</option>
                        <option value=1 <?php if (1 == $infoMascota[0]["MASCOTA"]) { ?>selected="selected"<?php } ?> >Gatos</option>
                        <option value=2 <?php if (2 == $infoMascota[0]["MASCOTA"]) { ?>selected="selected"<?php } ?> >Perros</option>
                        <option value=3 <?php if (3 == $infoMascota[0]["MASCOTA"]) { ?>selected="selected"<?php } ?> >Otro</option>
						<?php							
							//si existen datos en mascota se deshabilita la opcion ninguno
							if(!$mascota)
							{
						?>		
								<option value=99 <?php if (99 == $infoMascota[0]["MASCOTA"]) { ?>selected="selected"<?php } ?> >Ninguno</option>
						<?php } ?>
                    </select>
                </div>
                <?php
                $mostrar = 'style="display: none;"';
                if (3 == $infoMascota[0]["MASCOTA"]) {
                    $mostrar = '';
                }
                ?>
                <div class="form-group col-md-3" id="mostrarCual" <?php echo $mostrar; ?> >
                    <label class="control-label">Cu&aacute;l: </label>
                    <input type="text" id="cual" name="cual" value="<?php echo $infoMascota ? $infoMascota[0]["CUAL"] : ""; ?>" class="form-control" placeholder="Cu&aacute;l" maxlength="20" />
                </div>
                <div class="form-group col-md-2">
                    <label for="cuantos">Cuantos: *</label>
                    <input type="text" id="cuantos" name="cuantos" value="<?php echo $infoMascota ? $infoMascota[0]["CUANTOS"] : ""; ?>" 
                           <?php if ($infoMascota[0]["MASCOTA"] == 1) { echo 'disabled="disabled"'; } ?> class="form-control" placeholder="Cuantos" />
                </div>
                
                        <?php if($btnGuardarMasc == 'SI') {
                            echo "<div class='form-group col-md-3'><br>";
                            echo "<input type='button' id='btnMascota' name='btnMascota' value='Guardar Datos' class='btn btn-primary'/>";
                            echo "</div>";
                        } else if($btnGuardarMasc == 'NO') {
                            echo "<div class='form-group col-md-6'><br>";
                            echo "<div class='alert alert-warning'><strong>Atenci&oacute;n : </strong>No puede ingresar mas datos porque registro la opci&oacute;n ninguno.</div>";					
                            echo "</div>";
                        }
                        ?>
            </div>
            <br>
            
            <div class="alert alert-info">
                <h5 style="text-align: center;">Una vez diligenciada la información, podras continuar con el formulario de "Contacto para Emergencias".
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
                    <div id="div_guardado_academica" style="display:none">			
                        <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>
                    </div>	
                    <div id="div_error_academica" style="display:none">			
                        <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                    </div>	
                </div>
            </div>
        </form>
    </div>
    <div id="resultado"></div><!-- Carga lista -->
</div>
<?php } ?>