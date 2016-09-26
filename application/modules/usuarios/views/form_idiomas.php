<?php 
    if($user["POLITICA"] != 1) {
?> 	
    <div class='alert alert-danger text-center'><strong>Atenci&oacute;n: </strong>Para diligenciar este formulario, debes aceptar el "Aviso de privacidad para la recolecci&oacute;n de datos personales" ubicado en el formulario "Datos Usuario".</div>
<?php } else { ?>
<script type="text/javascript" src="<?php echo base_url("js/usuarios/idioma.js"); ?>"></script>
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
					IDIOMAS
				</h4>
			</div>
		</div>	
	<div class="well">
            <form  name="formIdioma" id="formIdioma" role="form" method="post" >
                <input type="hidden" id="hddIDIdioma" name="hddIDIdioma" value="<?php echo $infoIdioma?$infoIdioma[0]["ID_USER_IDIOMA"]:""; ?>"/>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="idiomas">Idioma: *</label>
                        <select name="idiomas" id="idiomas" class="form-control" autocomplete="off">
                                <option value='' >Seleccione...</option>
                                <?php for ($i = 0; $i < count($idiomas); $i++) { ?>
                                    <option value="<?php echo $idiomas[$i]["ID_IDIOMA"]; ?>" <?php if ($infoIdioma && $idiomas[$i]["ID_IDIOMA"] == $infoIdioma[0]["FK_ID_IDIOMA"]) { ?>selected="selected"<?php } ?>><?php echo $idiomas[$i]["IDIOMA"]; ?></option>	
                                <?php } ?>
                        </select>
                    </div>
                    <?php 
                        $mostrar =  'style="display: none;"';
                        if(99==$infoIdioma[0]["FK_ID_IDIOMA"]){ 
                              $mostrar =  '';
                        }  
                    ?>
                    <div class="form-group col-md-3" id="mostrarCual" <?php echo $mostrar; ?> >
                        <label class="control-label">Cu&aacute;l</label>
                        <input type="text" id="cual" name="cual" value="<?php echo $infoIdioma?$infoIdioma[0]["CUAL"]:""; ?>" class="form-control" placeholder="Cu&aacute;l" maxlength="30" required >
                    </div>

                    <div class="form-group col-md-2">
                            <label for="habla">Habla : *</label>
                            <select name="habla" id="habla" class="form-control" autocomplete="off">
                                    <option value='' >Seleccione...</option>
                                    <option value=1 <?php if(1==$infoIdioma[0]["HABLA"]){?>selected="selected"<?php }?> >Básico</option>
                                    <option value=2 <?php if(2==$infoIdioma[0]["HABLA"]){?>selected="selected"<?php }?> >Intermedio</option>
                                    <option value=3 <?php if(3==$infoIdioma[0]["HABLA"]){?>selected="selected"<?php }?> >Avanzado</option>
                                    <option value=4 <?php if(4==$infoIdioma[0]["HABLA"]){?>selected="selected"<?php }?> >Experto</option>
                                    <option value=5 <?php if(5==$infoIdioma[0]["HABLA"]){?>selected="selected"<?php }?> >Ninguno</option>
                            </select>
                    </div>                    
                    <div class="form-group col-md-2">
                            <label for="lee">Lee : *</label>
                            <select name="lee" id="lee" class="form-control" autocomplete="off">
                                    <option value='' >Seleccione...</option>
                                    <option value=1 <?php if(1==$infoIdioma[0]["LEE"]){?>selected="selected"<?php }?> >Básico</option>
                                    <option value=2 <?php if(2==$infoIdioma[0]["LEE"]){?>selected="selected"<?php }?> >Intermedio</option>
                                    <option value=3 <?php if(3==$infoIdioma[0]["LEE"]){?>selected="selected"<?php }?> >Avanzado</option>
                                    <option value=4 <?php if(4==$infoIdioma[0]["LEE"]){?>selected="selected"<?php }?> >Experto</option>
                                    <option value=5 <?php if(5==$infoIdioma[0]["LEE"]){?>selected="selected"<?php }?> >Ninguno</option>
                            </select>
                    </div>  
                    <div class="form-group col-md-2">
                            <label for="escribe">Escribe : *</label>
                            <select name="escribe" id="escribe" class="form-control" autocomplete="off">
                                    <option value='' >Seleccione...</option>
                                    <option value=1 <?php if(1==$infoIdioma[0]["ESCRIBE"]){?>selected="selected"<?php }?> >Básico</option>
                                    <option value=2 <?php if(2==$infoIdioma[0]["ESCRIBE"]){?>selected="selected"<?php }?> >Intermedio</option>
                                    <option value=3 <?php if(3==$infoIdioma[0]["ESCRIBE"]){?>selected="selected"<?php }?> >Avanzado</option>
                                    <option value=4 <?php if(4==$infoIdioma[0]["ESCRIBE"]){?>selected="selected"<?php }?> >Experto</option>
                                    <option value=5 <?php if(5==$infoIdioma[0]["ESCRIBE"]){?>selected="selected"<?php }?> >Ninguno</option>
                            </select>
                    </div>  
                    
                </div>
                <br>
                
                <div class="alert alert-info">
                    <h5 style="text-align: center;">Una vez diligenciada la información, podras continuar con el formulario de "Dependientes".
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
                        <input type="button" id="btnIdioma" name="btnIdioma" value="Guardar Datos" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
	</div>
    <div id="resultado"></div><!-- Carga lista -->
</div>
<?php } ?>